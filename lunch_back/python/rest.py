# from unittest import result
from urllib.request import urlopen
from urllib.parse import quote
import json
import pprint
# import sys

url2 = 'https://map.naver.com/v5/api/search?caller=pcweb&query='+ quote('돈까스') +'&type=all&searchCoord=128.591585;35.8666565&page=1&displayCount=20&isPlaceRecommendationReplace=true&lang=ko'
httpRes = urlopen(url2)
jsonData = json.load(httpRes)
print(jsonData['result']['place']['list'])
# return jsonData['result']['place']['list']

