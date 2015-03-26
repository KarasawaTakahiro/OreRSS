
# encoding: utf-8

import os
import urllib2
import time

class FeedUpdate():
    def __init__(self):
        os.environ["TZ"] = "Asia/Tokyo"                     # タイムゾーンの設定
        self.url = "http://211.120.198.187/orerss/updateFeed"     # フィード更新API
        self.headers = {"pragma":"no-cache"}                # HTTPヘッダ
        self.delay = 60                                     # 更新時間のチェックの間隔[sec]
        self.delayminute = 30                               # feedの更新間隔[min]
        self.outfile = "./log_update.txt"                   # ログファイル名

    def update(self):
        """
            更新処理呼び出し
        """
        self._update()

    def _update(self):
        """
            メイン処理
        """
        while True:
            minute = int(time.strftime("%M"))               # 現在の分を取得
            if minute % self.delayminute == 0:              # 更新タイミング?
            	self.log("start")
            	req = urllib2.Request(self.url, "\r\n", self.headers)   # リクエスト作成
            	res = urllib2.urlopen(req)                              # APIにリクエスト
            	self.log(res.read())                                    # 結果をログに記録
            time.sleep(self.delay)                          # スリープ

    def log(self, string):
        """
            ロギング
        """
        f = open(self.outfile, "a")                         # 追記でファイルオープン
        t = time.strftime("%Y/%m/%d %H:%M:%S %Z")           # YYYY/mm/dd HH:MM:SS TZ
        f.write("[%s] : udpate (%s)\n" % (t, string))       # 記録
        f.close()                                           # ファイルクローズ

if __name__ == "__main__":
    feedupdate = FeedUpdate()
    feedupdate.update()

