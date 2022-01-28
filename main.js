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
  "contact/index.html": "Contact",
  "webdesign/index.html": "Web Design",
  "portfolio/index.html": "Portfolio",
  "tips_tricks/index.html": "Tips and Tricks",
  "downloads/index.html": "Downloads",
  "links/index.html": "Links",
  "links/link_back/index.html": "Links - Link back to GDS",
  "guestbook/index.html": "Guestbook"
}

async function writeStaticPages() {
  for (let [path, title] of Object.entries(pageToTitle))
    await writePage(path, title);
}

async function readDB(jsonFile) {
  return JSON.parse(await Deno.readTextFile(jsonFile)).sort((a, b) => b.date.localeCompare(a.date));
}

async function writeFreeImagesPages() {
  const images = await readDB("db/free_images.json");

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

// Produces: "1998-03-31T21:00:00-00:00" => "Mar 1998"
function formatDateStr(dateStr) {
  const date = DateTime.parse(dateStr, "yyyy-MM-ddTHH:mm:ss-00:00");
  return months[date.getMonth()] + " " + DateTime.format(date, "yyyy");
}

async function writeCreationsPages() {
  const images = await readDB("db/creations.json");

  const htmlForImageType = async (type) => {
    const baseAssetPath = `/assets/creations/${type}/`;
    const assets = images.filter((i) => i.type == type);

    let htmls = assets.map(async (i) => {
      return await renderTemplate("creations/creation_item.html", {
        title: i.title,
        assetPath: baseAssetPath + "/" + i.path,
        type: i.type,
        path: i.path,
        date: formatDateStr(i.date),
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

async function writePortfolioPages() {
  const images = await readDB("db/portfolios.json");

  const htmlForImageType = async (type) => {
    const baseAssetPath = `/assets/portfolio/${type}/`;
    const assets = images.filter((i) => i.type == type);

    let htmls = assets.map(async (i) => {
      return await renderTemplate("portfolio/portfolio_item.html", {
        assetPath: baseAssetPath,
        title: i.title,
        cacheUrl: i.cacheUrl,
        thumbnail: i.thumbnail,
        url: i.url,
        date: formatDateStr(i.date),
        description: i.description
      });
    });
    return (await Promise.all(htmls)).join("\n");
  };

  writePage("portfolio/websites/index.html", "Portfolio - Websites",
            { assetsHtml: await htmlForImageType("website") });
  writePage("portfolio/logos/index.html", "Portfolio - Logos",
            { assetsHtml: await htmlForImageType("logo") });
  writePage("portfolio/interfaces/index.html", "Portfolio - Interfaces",
            { assetsHtml: await htmlForImageType("interface") });
}

async function writeDownloadsPages() {
  const images = await readDB("db/downloads.json");

  const htmlForImageType = async (type) => {
    const baseAssetPath = `/assets/downloads/${type}/`;
    const assets = images.filter((i) => i.type == type);

    let htmls = assets.map(async (i) => {
      return await renderTemplate("downloads/download_item.html", {
        assetPath: baseAssetPath,
        title: i.title,
        size: i.size,
        thumbnail: i.thumbnail,
        path: i.path,
        description: i.description
      });
    });
    return (await Promise.all(htmls)).join("\n");
  };

  writePage("downloads/fonts/index.html", "Downloads - Fonts",
            { assetsHtml: await htmlForImageType("font") });
}

await writeStaticPages();
await writeFreeImagesPages();
await writeCreationsPages();
await writePortfolioPages();
await writeDownloadsPages();
