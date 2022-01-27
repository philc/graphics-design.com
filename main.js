import * as Mustache from 'https://deno.land/x/mustache/mod.ts';
import * as Path from "https://deno.land/std@0.122.0/path/mod.ts";

async function writePage(path, title, templateParams) {
  const content = await renderPage(path, title, templateParams);
  const buildDir = "public";
  const destPath = Path.join(buildDir, path)
  Deno.mkdir(Path.dirname(destPath), { recursive: true });
  await Deno.writeTextFile(destPath, content);
}

async function renderTemplate(path, templateParams) {
  return await Mustache.renderFile(Path.join("pages", path), templateParams);
}

async function renderPage(path, title, templateParams) {
  const body = await renderTemplate(path, templateParams);
  return await Mustache.renderFile("pages/layout.html", { title: title, body: body});
}

const pageToTitle = {
  "index.html": "Free Web Graphics",
  "freeimages/index.html": "Free Images",
  "contact/index.html": "Contact"
}

async function writeStaticPages() {
  for (let [path, title] of Object.entries(pageToTitle))
    await writePage(path, title);
}

async function writeFreeImagesPages() {
  // TODO(philc):
  const images = JSON.parse(await Deno.readTextFile("db/free_images.json")).sort((a, b) => b.id - a.id)

  const htmlForImageType = async (type) => {
    const assets = images.filter((i) => i.type == type);
    return (await Promise.all(assets.map(async (i) => {
      return await renderTemplate("freeimages/image_item.html", {
        title: i.title,
        fileExtension: (type == "texture") ? "jpg" : "png",
        itemsInSet: i.itemsInSet,
        type: i.type,
        path: i.path,
        size: i.size,
        description: i.description
      });
    }))).join("\n");
  };

  writePage("freeimages/buttons/index.html", "Free Images - Buttons",
            { assetsHtml: await htmlForImageType("button") });
  writePage("freeimages/textures/index.html", "Free Images - Textures",
            { assetsHtml: await htmlForImageType("texture") });
}

await writeStaticPages();
await writeFreeImagesPages();
