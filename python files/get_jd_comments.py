import requests
from bs4 import BeautifulSoup as bs
import json
import argparse
import pymysql


class GetJdComment:
    def __init__(self):
        self.url_header = 'https://sclub.jd.com/comment/productPageComments.action'
        self.url_refer = 'https://item.jd.com/'
        self.search_url_header = 'https://search.jd.com/Search?keyword='
        self.s = requests.session()

        self.search_page_start = 1
        self.search_page_limit = 4

        self.get_comment_limit = 7
        self.productId = ''
        self.callback = 'fetchJSON_comment98vv6560'

        self.db_info = {
            'host': 'host',
            'username': 'username',
            'pass': 'pass',
            'dbname': 'dbname'
        }

        self.params = {
            'callback': self.callback,
            'productId': self.productId,
            'score': 0,
            'sortType': 5,
            'page': 0,
            'pageSize': 10,
            'isShadowSku': 0,
            'rid': 0,
            'fold': 1
        }

        self.headers = {
            'Referer': self.url_refer+self.productId+'.html',
            'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36'
        }

        db_info = self.db_info
        self.db = pymysql.connect(db_info['host'], db_info['username'], db_info['pass'], db_info['dbname'])
        self.cursor = self.db.cursor()
        # first you should build a table for your insert & save data. see sql/jd.sql

    def get_comment(self, id):
        self.params['productId'] = id
        while self.params['page'] < self.get_comment_limit:
            t = self.s.get(self.url_header, params=self.params, headers=self.headers).text
            try:
                t = t[len(self.callback) + 1:-2]
            except Exception as e:
                print('anonymous err occurs!')
                exit()

            cmt_json = json.loads(t)
            comment_json = cmt_json['comments']

            for comment in comment_json:
                c_id = comment['id']
                c_userLevel = comment['userLevelName']
                c_creationTime = comment['referenceTime']
                c_content = comment['content']
                c_nickname = comment['nickname']
                c_score = comment['score']
                # c_goodName = comment['referenceName']
                c_client = comment['userClientShow']
                print('{} {} {} {} {}\n {}\n {}\n'.format(c_id, c_nickname, c_userLevel, c_score, c_client, c_content,
                                                          c_creationTime))
                self.insert_comment_into_db(c_id, c_nickname, c_userLevel, c_score, c_client, c_content, c_creationTime)
            self.params['page'] += 1

    def insert_comment_into_db(self, id, nickname, userLevel, score, client, content, creationTime):
        id = str(id)
        insert_sql = """
                INSERT INTO jd_comment(g_id, g_nickname, g_level, g_score, g_client, g_content, g_date)
                values ('%s','%s', '%s', '%d', '%s', '%s', '%s')
            """ % (id, nickname, userLevel, score, client, content, creationTime)

        try:
            self.cursor.execute(insert_sql)
            self.db.commit()
            print('insert successful')
        except:
            print('*' * 10, 'something error when insert into db', '*' * 10)

    def find_goods_item(self, keyword):
        while self.search_page_start < self.search_page_limit:
            full_search_url = self.search_url_header + str(keyword) + "&page=" + str(self.search_page_start)
            print(full_search_url)
            f = self.s.get(full_search_url, headers=self.headers)
            f.encoding = f.apparent_encoding
            text = bs(f.text, 'lxml')
            good_list = text.select('#J_goodsList > ul > li')
            for item in good_list:
                id = item.get('data-sku')
                name = item.select('div.gl-i-wrap > div.p-name > a > em')[0].text
                price = item.select('div.gl-i-wrap > div.p-price > strong > i')[0].text.split('.')[0]
                shop = item.select('div.gl-i-wrap > div.p-shop')[0].text.lstrip('\n')
                print('id:', id, ' name:', name, ' price:', price, ' shop:', shop)
                self.insert_goods_info_into_db(id, name, int(price), shop)
            self.search_page_start += 1

    def insert_goods_info_into_db(self, id, name, price, shop):

        info_sql = """
                  INSERT INTO jd_gooditems(g_id, g_name, g_price, g_shop)
                  values ('%s','%s', '%d', '%s')
              """ % (id, name, price, shop)

        try:
            self.cursor.execute(info_sql)
            self.db.commit()
            print('insert successful')
        except:
            print('*' * 10, 'something error when insert goods\'s info into db', '*' * 10)

    def end_phase(self):
        self.db.close()
        print('db has been closed')


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description="This arg parser is for search items")
    parser.add_argument('-i', '--item', help="item's name", type=str)
    parser.add_argument('-v', '--value', help="item's id number", type=str)
    args = parser.parse_args()
    gt = GetJdComment()
    if args.item is not None:
        gt.find_goods_item(args.item)
    if args.value is not None:
        gt.get_comment(args.value)