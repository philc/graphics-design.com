require "rubygems"
require "dm-core"

# Functions for counting, like Word.all.count
require "dm-aggregates"

# DATABASE_URL is provided by heroku.
DataMapper.setup(:default, ENV["DATABASE_URL"] ||
  "sqlite3:#{File.dirname(__FILE__)}/db/gds.db")

class Download
  include DataMapper::Resource

  property :id, Integer, :nullable => false, :serial => true, :key => true
  property :title, String, :nullable => false, :length => 30
  property :path, String, :nullable => false, :length => 40
  property :thumbnail, String, :length => 40
  property :author, String, :length => 30
  property :description, Text
  property :rating, Integer
  property :size, Integer
  property :date, DateTime, :nullable => false
  property :type, String, :nullable => false
  property :subtype, String, :length => 30
end

class Portfolio
  include DataMapper::Resource

  property :id, Integer, :nullable => false, :serial => true, :key => true
  property :title, String, :nullable => false, :limit => 40
  property :description, Text
  property :date, DateTime, :nullable => false
  property :url, String, :limit => 45
  property :cache_url, String, :limit => 45, :field => "cacheUrl"
  property :thumbnail, String, :limit => 45
  property :type, String, :limit => 30
end

class Creation
  include DataMapper::Resource

  property :id, Integer, :nullable => false, :serial => true, :key => true
  property :title, String, :nullable => false, :limit => 30
  property :path, String, :limit => 30
  property :description, Text
  property :date, DateTime, :nullable => false
  property :type, String, :limit => 30
end


class FreeImage
  include DataMapper::Resource
  property :id, Integer, :nullable => false, :serial => true, :key => true
  property :path, String, :limit => 30
  property :title, Text
  property :description, Text
  property :items_in_set, Integer, :nullable => false, :field => "itemsInSet"
  property :size, Float
  property :date, DateTime, :nullable => false
  property :type, String, :limit => 30, :nullable => false

  def file_extension
    self.type == "texture" ? "jpg" : "png"
  end
end
