require "rubygems"
require "dm-core"

# Functions for counting, like Word.all.count
require "dm-aggregates"

DataMapper.setup(:default, "sqlite3:#{File.dirname(__FILE__)}/db/gds.db")

class Download
  include DataMapper::Resource

  property :id, Integer, :serial => true, :key => true
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

DataMapper.auto_upgrade!