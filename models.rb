require "rubygems"
require "dm-core"

# Functions for counting, like Word.all.count
require "dm-aggregates"
require "dm-migrations"

# DATABASE_URL is provided by heroku.
DataMapper.setup(:default, ENV["DATABASE_URL"] ||
  "sqlite3:#{File.dirname(__FILE__)}/db/gds.db")

class Download
  include DataMapper::Resource

  property :id, Serial, :key => true
  property :title, String, :length => 30
  property :path, String, :length => 40
  property :thumbnail, String, :length => 40
  property :author, String, :length => 30
  property :description, Text
  property :rating, Integer
  property :size, Integer
  property :date, DateTime
  property :type, String
  property :subtype, String, :length => 30
end

class Portfolio
  include DataMapper::Resource

  property :id, Serial, :key => true
  property :title, String
  property :description, Text
  property :date, DateTime
  property :url, String
  property :cache_url, String, :field => "cacheUrl"
  property :thumbnail, String
  property :type, String
end

class Creation
  include DataMapper::Resource

  property :id, Serial, :key => true
  property :title, String
  property :path, String
  property :description, Text
  property :date, DateTime
  property :type, String
end


class FreeImage
  include DataMapper::Resource
  property :id, Serial, :key => true
  property :path, String
  property :title, Text
  property :description, Text
  property :items_in_set, Integer, :field => "itemsInSet"
  property :size, Float
  property :date, DateTime
  property :type, String

  def file_extension
    self.type == "texture" ? "jpg" : "png"
  end
end

DataMapper.auto_upgrade!
