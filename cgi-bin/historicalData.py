import requests

search = {'garbage': 0}
resp = requests.post("http://dbsystems.web.engr.illinois.edu/pages/historical_data.php", data=search)
print resp.text
