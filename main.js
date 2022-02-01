// This builds the site and stages it into the docs/ folder.
// Invoke with deno run --allow-write --allow-read --unstable main.js

import * as Mustache from 'https://deno.land/x/mustache@v0.3.0/mod.ts';
import * as Path from "https://deno.land/std@0.122.0/path/mod.ts";
import * as DateTime from "https://deno.land/std@0.122.0/datetime/mod.ts";
import * as fs from "https://deno.land/std@0.122.0/fs/mod.ts";
// Not stable as of 2022-01-31; requires --unstable flag:
import * as fsCopy from "https://deno.land/std@0.122.0/fs/copy.ts";

const buildDir = "docs";

async function renderTemplate(path, templateParams) {
  return await Mustache.renderFile(Path.join("pages", path), templateParams);
}

async function renderPage(path, title, templateParams) {
  const body = await renderTemplate(path, templateParams);
  return await Mustache.renderFile("pages/layout.html", { title: title, body: body});
}

async function writePage(path, title, templateParams) {
  const content = await renderPage(path, title, templateParams);
  const destPath = Path.join(buildDir, path);
  await fs.ensureDir(Path.dirname(destPath));
  await Deno.writeTextFile(destPath, content);
}

const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

// Transforms "1998-03-31T21:00:00-00:00" => "Mar 1998"
function formatDateStr(dateStr) {
  const date = DateTime.parse(dateStr, "yyyy-MM-ddTHH:mm:ss-00:00");
  return months[date.getMonth()] + " " + DateTime.format(date, "yyyy");
}

async function readDB(jsonFile) {
  return JSON.parse(await Deno.readTextFile(jsonFile)).sort((a, b) => b.date.localeCompare(a.date));
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
  // 404.html doesn't render itself inside layout.html.
  Deno.copyFile("pages/404.html", Path.join(buildDir, "404.html"));
}

async function writeFreeImagesPages() {
  const images = await readDB("db/free_images.json");

  const htmlForImageType = async (type) => {
    const assets = images.filter((i) => i.type == type);
    let htmls = assets.map(async (i) => {
      return await renderTemplate("freeimages/image_item.html", {
        id: i.id,
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

  // Every "free image" set has its own viewer page displaying the images in the set.
  for (let image of images) {
    const items = [];
    const extension = (image.type == "texture") ? "jpg" : "png";
    for (let j = 1; j <= image.itemsInSet; j++)
      items.push({ path: `/assets/freeimages/${image.type}/${image.path}/${j}.${extension}` });
    const content = await renderPage("freeimages/image_set.html",
                                     `Free images - ${image.id}`,
                                     { images: items });
    const destPath = Path.join(buildDir, `freeimages/image_set/${image.id}.html`);
    await fs.ensureDir(Path.dirname(destPath));
    await Deno.writeTextFile(destPath, content);
  }
}

async function writeCreationsPages() {
  const images = await readDB("db/creations.json");

  const htmlForImageType = async (type) => {
    const baseAssetPath = `/assets/creations/${type}/`;
    const assets = images.filter((i) => i.type == type);
    const htmls = assets.map(async (i) => {
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
    const htmls = assets.map(async (i) => {
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
    const htmls = assets.map(async (i) => {
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

async function buildWebsite() {
  await fsCopy.copy("public", "docs", { overwrite: true });

  await writeStaticPages();
  // Write each section of the site.
  await writeFreeImagesPages();
  await writeCreationsPages();
  await writePortfolioPages();
  await writeDownloadsPages();
}

buildWebsite();
