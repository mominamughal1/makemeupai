import api from "./api";

export async function getRecommendations(occasion) {
  const { data } = await api.get("/api/recommendations", {
    params: { occasion },
  });
  return data.data.combinations;
}
