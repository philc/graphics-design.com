# graphics-design.com

This repo contains the contents of my homepage circa 1998: <a
href="https://www.graphics-design.com">graphics-design.com</a>!

# Implementation notes for my future self

## History

* This site was originally written in PHP in 1998.
* In 2009 I converted it to a Ruby Sinatra app so I could serve it via Heroku.
* In 2022 I converted it to a static HTML site, so it could be served from anywhere (currently Github Pages).
  The site is generated using Javascript and Deno. This should now be very simple and future proof; I intend
  for it require zero maintenance for a full century -- until 2122!

## Howto

main.js builds the site:

        deno run --allow-write --allow-read --unstable main.js
        (or just ./main.js)

The site is staged into "docs/", because this is the folder that Github Pages sources its content from.
