import subprocess
import json
import sys
import os
import requests
num_pages = 10

prod_list = ["apple", "mouse pad", "desktop", "mouse", "monitor", "tv", "speakers", "lg", "samsung", "keyboard", "laptop", 
		"notebooks", "dell", "macbook", "video games", 'games', "tablets", "phone charger", "cameras", "dslr", "gaming", 'windows', 'android', 
		'cell phones', 'headphones', 'wireless', 'fitbit', 'smart watch', 'charging cable', 'lenovo', 'sd','consoles', 'controllers', 'sony', 'nikon', 'canon', 'hp', 'google', 'vizio']
prod_list2 = ['xbox', 'playstation', 'ps4 games', 'nintendo','playstation games', 'xbox games', 'video games','shooter games', 'sport games', 'arcade games'
		'ea sports', 'warner bros', 'rockstar games', 'activision', 'ubisoft', 'wii', 'rpg games', 'console games',
		'pc games', 'wii u games', 'zelda game', '2k games', 'fifa']

for prod in prod_list2:
	for i in range(0, num_pages*2 + 5):
		print "Current page: " + str(i)
		search = {'product_name': prod, 'page': i*10 + 1}
		resp = requests.post("http://dbsystems.web.engr.illinois.edu/pages/product_search_crawl.php", data=search)
		#print resp.text()
	print "Completed crawl for: " + str(prod)

for prod in prod_list:
	for i in range(0, num_pages):
		print "Current page: " + str(i)
		search = {'product_name': prod, 'page': i*10 + 1}
		resp = requests.post("http://dbsystems.web.engr.illinois.edu/pages/product_search_crawl.php", data=search)
		#print resp.text()
	print "Completed crawl for: " + str(prod)
