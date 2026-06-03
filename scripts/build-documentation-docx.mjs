import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";
import {
  Document,
  Packer,
  Paragraph,
  TextRun,
  HeadingLevel,
  AlignmentType,
} from "docx";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname, "..");
const mdPath = path.join(root, "docs", "MakemeupAI-Project-Documentation.md");
const outPath = path.join(root, "docs", "MakemeupAI-Project-Documentation.docx");

function parseMarkdownToParagraphs(markdown) {
  const lines = markdown.split(/\r?\n/);
  const children = [];

  for (const line of lines) {
    if (line.trim() === "" || line.trim() === "---") {
      children.push(new Paragraph({ spacing: { after: 120 } }));
      continue;
    }

    if (line.startsWith("# ")) {
      children.push(
        new Paragraph({
          heading: HeadingLevel.TITLE,
          alignment: AlignmentType.CENTER,
          spacing: { after: 240 },
          children: [new TextRun({ text: line.slice(2).trim(), bold: true, size: 32 })],
        })
      );
      continue;
    }

    if (line.startsWith("## ")) {
      children.push(
        new Paragraph({
          heading: HeadingLevel.HEADING_1,
          spacing: { before: 280, after: 160 },
          children: [new TextRun({ text: line.slice(3).trim(), bold: true, size: 28 })],
        })
      );
      continue;
    }

    if (line.startsWith("### ")) {
      children.push(
        new Paragraph({
          heading: HeadingLevel.HEADING_2,
          spacing: { before: 200, after: 120 },
          children: [new TextRun({ text: line.slice(4).trim(), bold: true, size: 24 })],
        })
      );
      continue;
    }

    if (line.startsWith("|") && line.includes("|")) {
      children.push(
        new Paragraph({
          spacing: { after: 80 },
          children: [new TextRun({ text: line.trim(), size: 20 })],
        })
      );
      continue;
    }

    if (line.startsWith("- ") || line.startsWith("* ")) {
      children.push(
        new Paragraph({
          bullet: { level: 0 },
          spacing: { after: 80 },
          children: [new TextRun({ text: line.slice(2).trim(), size: 22 })],
        })
      );
      continue;
    }

    if (line.startsWith("```")) {
      continue;
    }

    const cleaned = line
      .replace(/\*\*(.+?)\*\*/g, "$1")
      .replace(/`([^`]+)`/g, "$1")
      .trim();

    if (cleaned) {
      children.push(
        new Paragraph({
          spacing: { after: 120 },
          children: [new TextRun({ text: cleaned, size: 22 })],
        })
      );
    }
  }

  return children;
}

const markdown = fs.readFileSync(mdPath, "utf8");
const doc = new Document({
  sections: [
    {
      properties: {},
      children: parseMarkdownToParagraphs(markdown),
    },
  ],
});

const buffer = await Packer.toBuffer(doc);
fs.writeFileSync(outPath, buffer);
console.log(`Wrote ${outPath}`);
