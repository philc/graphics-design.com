import * as Mustache from 'https://deno.land/x/mustache/mod.ts';
import * as Path from "https://deno.land/std@0.122.0/path/mod.ts";
import * as DateTime from "https://deno.land/std@0.122.0/datetime/mod.ts";

async function writePage(path, title, templateParams) {
  const content = await renderPage(path, title, templateParams);
  const buildDir = "public";
  const destPath = Path.join(buildDir, path)
  let c = Path.dirname(destPath);
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
  "creations/index.html": "Creations",
  "contact/index.html": "Contact"
}

async function writeStaticPages() {
  for (let [path, title] of Object.entries(pageToTitle))
    await writePage(path, title);
}

async function writeFreeImagesPages() {
  const images = JSON.parse(await Deno.readTextFile("db/free_images.json")).
        sort((a, b) => b.date.localeCompare(a.date));

  const htmlForImageType = async (type) => {
    const assets = images.filter((i) => i.type == type);
    let htmls = assets.map(async (i) => {
      return await renderTemplate("freeimages/image_item.html", {
        title: i.title,
        fileExtension: (type == "texture") ? "jpg" : "png",
        itemsInSet: i.itemsInSet,
        type: i.type,
        path: i.path,
        size: i.size,
        description: i.description
      });
    });
    return (await Promise.all(htmls)).join("\n");
  };

  writePage("freeimages/buttons/index.html", "Free Images - Buttons",
            { assetsHtml: await htmlForImageType("button") });
  writePage("freeimages/textures/index.html", "Free Images - Textures",
            { assetsHtml: await htmlForImageType("texture") });
}

const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

async function writeCreationsPages() {
  const images = JSON.parse(await Deno.readTextFile("db/creations.json")).
        sort((a, b) => b.date.localeCompare(a.date));

  const htmlForImageType = async (type) => {
    const baseAssetPath = `/assets/creations/${type}/`;
    const assets = images.filter((i) => i.type == type);

    let htmls = assets.map(async (i) => {
      const date = DateTime.parse(i.date, "yyyy-MM-ddTHH:mm:ss-00:00");
      return await renderTemplate("creations/creation_item.html", {
        title: i.title,
        assetPath: baseAssetPath + "/" + i.path,
        type: i.type,
        path: i.path,
        date: months[date.getMonth()] + " " + DateTime.format(date, "yyyy"),
        description: i.description,
        isInterface: type == "interface",
        isDesktop: type == "desktop",
        isLogo: type == "logo"
      });
    });
    return (await Promise.all(htmls)).join("\n");
  };

  writePage("creations/desktops/index.html", "Creations - Desktops",
            { assetsHtml: await htmlForImageType("desktop") });
  writePage("creations/interfaces/index.html", "Creations - Interfaces",
            { assetsHtml: await htmlForImageType("interface") });
  writePage("creations/logos/index.html", "Creations - Logos",
            { assetsHtml: await htmlForImageType("logo") });
}

await writeStaticPages();
await writeFreeImagesPages();
await writeCreationsPages();
