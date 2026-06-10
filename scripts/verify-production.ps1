param(
    [Parameter(Mandatory = $true)]
    [string]$ApiUrl,
    [string]$FrontendUrl = "https://makemeupai.vercel.app"
)

Write-Host "Production smoke checks"
Write-Host "API: $ApiUrl"
Write-Host "Frontend: $FrontendUrl"
Write-Host ""

function Test-Endpoint {
    param([string]$Name, [string]$Url, [int[]]$Expected = @(200))
    try {
        $response = Invoke-WebRequest -Uri $Url -UseBasicParsing -TimeoutSec 30
        if ($Expected -contains $response.StatusCode) {
            Write-Host "[OK] $Name ($($response.StatusCode))"
            return $true
        }
        Write-Host "[FAIL] $Name (got $($response.StatusCode), expected $($Expected -join '/'))"
        return $false
    } catch {
        $status = $_.Exception.Response.StatusCode.value__
        if ($status -and ($Expected -contains $status)) {
            Write-Host "[OK] $Name ($status)"
            return $true
        }
        Write-Host "[FAIL] $Name ($($_.Exception.Message))"
        return $false
    }
}

$api = $ApiUrl.TrimEnd("/")
$fe = $FrontendUrl.TrimEnd("/")

$results = @(
    (Test-Endpoint "API health" "$api/up"),
    (Test-Endpoint "Beauticians API" "$api/api/beauticians"),
    (Test-Endpoint "Frontend home" $fe),
    (Test-Endpoint "Frontend signup" "$fe/signup")
)

if ($results -contains $false) {
    exit 1
}

Write-Host ""
Write-Host "All checks passed. Run manual auth/face-insights tests in the browser."
