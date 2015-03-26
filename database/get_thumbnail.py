#! /usr/bin/env python
# coding: utf-8

from BeautifulSoup import BeautifulStoneSoup

import datetime
import logging
import mysql.connector
import urllib2
import re
import time

# logging
LOGFILE = "get_thumbnail.log"
logging.basicConfig(filename=LOGFILE, level=logging.DEBUG)

class GetThumbnail():
    def __init__(self, user, passwd, host, database, charset):
        """
            サムネイルを取得する
        """
        # API
        self.api = "http://ext.nicovideo.jp/api/getthumbinfo/sm"

        # DB
        self.user = user
        self.passwd = passwd
        self.host = host
        self.database = database
        self.charset = charset
        self.connect = None
        self.cursor = None

    def open(self):
        """
            DBに接続する
        """
        self.connect = mysql.connector.connect(
                user=self.user, password=self.passwd, host=self.host,
                database=self.database, charset=self.charset,
                buffered=True, use_unicode=True
                )
        self.cursor = self.connect.cursor()

    def close(self):
        """
            DBから切断する
        """
        self.cursor.close()
        self.connect.close()

    def _execute(self, query, escape=tuple()):
        """
            cursor.execute() のシンボル
        """
        self.cursor.execute(query, escape)

    def _get_unregistered(self):
        """
            未取得のカラムを取得
        """
        self._execute("""SELECT id, link FROM item
                WHERE thumbnail IS NULL 
                ;""")
        return self.cursor.fetchall()

    def _pickup_smid(self, string):
        """
            URLからsmIDの数値部分を取り出す
            マッチしなければFalseを返す
        """

        match = re.search(r"watch/sm[0-9]+", string)    # watch/sm0000を抜き出す
        if match:
            return match.group()[8:]                    # 数値部分を取り出す
        else:
            return False

    def _thumbinfo(self, id):
        """
            getthumbinfoにアクセスしてXMLを取得
        """
        url = self.api + id
        return BeautifulStoneSoup(urllib2.urlopen(url).read())

    def _get_thumbnail_url(self, url):
        """
            動画URLからサムネのURLを取得
        """
        id = self._pickup_smid(url)
        if id:
            soup = self._thumbinfo(id)
            find = soup.find('thumbnail_url')
            if find:
                return str(find.string)
            else:
                return ''
        else:
            return ''

    def _set_thumbnail_url(self, id, url):
        """
            DBにサムネイルURLを登録
        """
        self._execute("""UPDATE item
                SET thumbnail = %s
                WHERE id = %s
                ;""", (url, id,))
        self.commit()

    def commit(self):
        self.connect.commit()

    def main(self):
        self.open()

        count = 0
        for id, url in self._get_unregistered():
            thumb = self._get_thumbnail_url(url)
            self._set_thumbnail_url(id, thumb)
            self.commit()
            count += 1
        logging.info("regist: %d" % count)
        self.close()

def get_thumbnail(user, passwd, host, dbname, charset):
    if passwd == "NONE": passwd = ""

    logging.info("wakeup at %s" % datetime.datetime.now())

    getthumbnail = GetThumbnail(user, passwd, host, dbname, charset)

    while True:
        now = datetime.datetime.now()
        if now.hour == 3:                   # 3時台
            logging.info("start at %s" % now)
            getthumbnail.main()
            logging.info("finish at %s" % now)
            time.sleep(1 * 60 * 60 * 23)    # 23時間
            time.sleep(1 * 60 * 30)         # 30分
        else:
            time.sleep(1 * 60)              # 1分


if __name__ == "__main__":
    import sys

    if len(sys.argv) == 6:
        get_thumbnail(sys.argv[1], sys.argv[2], sys.argv[3], sys.argv[4], sys.argv[5])
    else:
        print "useage: python %s username password host database_name charset" % sys.argv[0]


