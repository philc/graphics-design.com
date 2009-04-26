require "rubygems"
require "sinatra"

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

def render_with_title(page)
  erb page, :locals => { :title => TITLES[page] }
end