# -*- coding: utf-8 -*-  
import requests
import re
from bs4 import BeautifulSoup
import sys
import redis
import random
import json
CONFIG={
	
	'savepath':"D:/pp.txt"
}
REDIS_CONFIG={
	'host':'127.0.0.1',
	'port':6379,
	'db':3
}
#main proccess to fetch the stories from web 
class Fetch():
	"""docstring for Fetch"""
	def __init__(self, url,page):
		self.url="https://www.pengfu.com/"
		self.page=page
		pool=redis.ConnectionPool(host=REDIS_CONFIG['host'], port=REDIS_CONFIG['port'],db=REDIS_CONFIG['db'])
		self.r=redis.Redis(connection_pool=pool)
	def PageData(self,pagest):
		joke=[]
		self.pageurl=self.url+ "xiaohua_%d.html" % (pagest)
		res=requests.get(self.pageurl)
		res.encoding ='utf-8'
		soup=BeautifulSoup(res.text,'html.parser')
		realjoke=soup.find_all('div',attrs={'class':re.compile("list-item bg1 b1 boxshadow"),'id':re.compile("\d+")})
		for x in realjoke:
	   		ass=x.find('div',attrs={'class':'content-img clearfix pt10 relative'}).string
	   		if ass:
		            joke.append(ass)
		# return joke
		self.r.setex('JOKE',json.dumps(joke),60*60*2)
		print(json.dumps(joke))
	def GetAll(self):
		#for x in range(1,self.page+1):
		print 'downloading page....',self.page
		self.PageData(self.page)
snake=Fetch("https://www.pengfu.com/",random.randint(1,6))
snake.GetAll()
