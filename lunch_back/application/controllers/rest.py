from pprint import pprint
import sys
import io
# from unittest import result
from urllib.request import urlopen
from urllib.parse import quote
import json
# import pandas as pd

sys.stdout = io.TextIOWrapper(sys.stdout.detach(), encoding='utf-8')
sys.stderr = io.TextIOWrapper(sys.stderr.detach(), encoding='utf-8')

def call(var_1):
    # 무언가를 처리하고..
    url2 = 'https://map.naver.com/v5/api/search?caller=pcweb&query='+ quote(var_1) +'&type=all&searchCoord=128.591585;35.8666565&page=1&displayCount=20&isPlaceRecommendationReplace=true&lang=ko'
    httpRes = urlopen(url2)
    # print(httpRes)
    jsonData = json.load(httpRes)
    # print로 값을 return해서 php에서 받을 수 있음
    # print(jsonData['result']['place']['list'])
    menuList = jsonData['result']['place']['list']
    # print(menuList)
    totalList = list()
    for i in range(len(menuList)):
        itemList = {}
        itemList["name"] = format(menuList[i].get('name'))
        itemList['category'] = format(menuList[i].get('category'))
        itemList['address'] = format(menuList[i].get('address'))
        itemList['telDisplay'] = format(menuList[i].get('telDisplay'))
        itemList['thumUrl'] = format(menuList[i].get('thumUrl'))
        itemList['x'] = format(menuList[i].get('x'))
        itemList['y'] = format(menuList[i].get('y'))
        itemList['bizhourInfo'] = format(menuList[i].get('bizhourInfo'))
        itemList['menuInfo'] = format(menuList[i].get('menuInfo'))
        itemList['distance'] = format(menuList[i].get('distance'))
        totalList.append(itemList)
        # print(list[i])
    print(totalList)
    # df1 = pd.DataFrame(list)
    # print(df1)


call(sys.argv[1])
# call('라면')
sys.exit()