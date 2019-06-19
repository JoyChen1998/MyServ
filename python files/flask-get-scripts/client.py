import requests

r = requests.get("http://127.0.0.1:8888/item?item=hello")

print(r.text)
