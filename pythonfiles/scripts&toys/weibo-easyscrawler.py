import time
import requests as r
import re
from PIL import Image
import random
from urllib.parse import quote_plus
import http.cookiejar as cookielib
import json
import csv

SRC_URL = 'https://m.weibo.cn/api/container/getIndex'
params = {
    'type': 'uid',
    'value': '6217939256',      # 哪吒电影的ID
    'containerid': '1076036217939256'
}

csv_header = ['ID', 'CreateTime', 'repostNum', 'commentNum', 'likeNum', 'Contents']

headers={
    "User-Agent": "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.1.6) ",
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "Accept-Language": "en-us",
    "Connection": "keep-alive",
    "Accept-Charset": "GB2312,utf-8;q=0.7,*;q=0.7"
}

req = r.session()
maxn = 1

weibo_contents = {
    'createDate': [],
    'contents': [],
    'repostNum': [],
    'commentNum': [],
    'attitudesNum': []
}

ID = 0

if __name__ == '__main__':
    f = open('wBlog.csv', 'a')
    f_csv = csv.writer(f)

    while maxn <= 1:
        print("now it's ", maxn, " time to get data!")
        maxn += 1
        time.sleep(2)
        result = req.get(SRC_URL, params=params, headers=headers)
        res = result.content
        print(res)
        json_data = json.loads(str(res, encoding='utf-8'))
        data = json_data['data']

        nextId = data['cardlistInfo']['since_id']
        tweetContent = data['cards']

        for i in range(1, len(tweetContent)):
            ID += 1
            tweet = tweetContent[i]
            blog = tweet['mblog']
            create_time = blog['created_at']
            weibo_content = blog['text']
            reposts_num = blog['reposts_count']
            comments_num = blog['comments_count']
            attitude_num = blog['attitudes_count']
            print("ID = %d,createTime = %s, content = %s.\n\t get reposts:%d, comments:%d, like:%d" %
                  (ID, create_time, weibo_content, reposts_num, comments_num, attitude_num))
            row = [ID, create_time, reposts_num, comments_num, attitude_num, weibo_content]
            f_csv.writerow(row)

        print()

    f.close()


