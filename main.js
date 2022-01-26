import * as Mustache from 'https://deno.land/x/mustache/mod.ts';
import * as Path from "https://deno.land/std@0.122.0/path/mod.ts";

async function writePage(pagePath, content) {
  const buildDir = "public";
  const destPath = Path.join(buildDir, pagePath)
  Deno.mkdir(Path.dirname(destPath), { recursive: true });
  await Deno.writeTextFile(destPath, content);
}

async function renderPage(path, title, templateParams) {
  const body = await Mustache.renderFile(Path.join("pages", path), templateParams);
  return await Mustache.renderFile("pages/layout.html", { title: title, body: body});
}

const pageToTitle = {
  "index.html": "Free Web Graphics",
  "contact/index.html": "Contact"
}

async function writeStaticPages() {
  for (let [path, title] of Object.entries(pageToTitle))
    writePage(path, await renderPage(path, title));
}

async function writeFreeImagesPages() {
  // TODO(philc):
  // let creations = JSON.parse(await Deno.readTextFile("db/creations.json"));
  // console.log(">>>> creations.length:", creations.length);
  // console.log(">>>> creations[0]:", creations[0]);
}

await writeStaticPages();
