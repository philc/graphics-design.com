require "rubygems"
require "sinatra"
require "models"
# todo: add some php routes in here so downloads/fonts.php works.
# I'm storing the title for each page in the page's file; I then pass that title to the surrounding
# template. Parse out the line <% @title = "About" %> from each view file.
unless defined? TITLES
  TITLES = {}
  # Dir["views/*.erb"].each do |file|
  Dir["views/index.erb"].each do |file|
    next if file =~ /site_layout/
    title = File.read(file).match(/<% @title = "(.+?)" %>/)[1]
    file = File.basename(file).sub(".erb", "")
    TITLES[file.to_sym] = title
  end
end


get "/" do
  render_with_title :index
end

get "/:section/?" do
  render_with_title "#{params[:section]}/index".to_sym
end

get "/:section/:subsection" do
  render_with_title "#{params[:section]}/#{params[:subsection]}".to_sym
end

def render_with_title(page)
  erb page, :locals => { :title => TITLES[page] }
end