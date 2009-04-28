require "rubygems"
require "sinatra"
require "models"

# Redirects for older versions of this site.
# It used to be written in php and some pages link to .php
get("/freeImages/*") { redirect301 request.url.gsub("freeImages", "freeimages") }
get("/webDesign/*") { redirect301 request.url.gsub("webDesign", "webdesign") }
get("/tipsTricks/*") { redirect301 request.url.gsub("tipsTricks", "tips_tricks") }

def redirect301(url)
  header "Location" => url
  status 301 # try with 303 as well
end

# todo: add some php routes in here so downloads/fonts.php works.
# I'm storing the title for each page in the page's file; I then pass that title to the surrounding
# template. Parse out the line <% @title = "About" %> from each view file.
unless defined? TITLES
  TITLES = {}
  Dir["views/**/*.erb"].each do |file|
    match = File.read(file).match(/<% @title = "(.+?)" %>/)
    next unless match
    title = match[1]
    file = file.sub("views/", "").sub(".erb", "")
    TITLES[file.to_sym] = title
  end
end

get "/" do
  render_with_title :index
end

get "/contact/?" do
  render_with_title :contact
end

get "/guestbook/?" do
  render_with_title :guestbook
end

get "/view_image_set*" do
  next "" unless params[:id]
  image = FreeImage.first(:id => params[:id].to_i)
  puts "###### image : #{image.inspect}"
  next "" unless image
  render_with_title "freeimages/view_image_set".to_sym, :image => image
end

get "/:section/?" do
  render_with_title "#{params[:section]}/index".to_sym
end

get "/:section/:subsection" do
  render_with_title "#{params[:section]}/#{params[:subsection]}".to_sym,
    :offset => (params[:offset] || 0).to_i, :limit => (params[:limit] || 6).to_i
end

def render_with_title(page, locals = {})
  erb page, :locals => locals.merge({ :title => TITLES[page] })
end