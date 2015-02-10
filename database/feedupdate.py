
# encoding: utf-8

import urllib2
import time

class FeedUpdate():
    def __init__(self):
        self.url = "http://localhost/orerss/updateFeed"
        #self.delay = 60
        #self.delayminute = 10

        self.delay = 30
        self.delayminute = 1

        self.headers = {"pragma":"no-cache"}
        self.outfile = "./log_update.txt"

    def update(self):
        self._update()

    def _update(self):
        minute = int(time.strftime("%M"))
        while True:
            if minute % self.delayminute == 0:
                req = urllib2.Request(self.url, "\r\n", self.headers)
                res = urllib2.urlopen(req)
                self.log(res.read())
            time.sleep(self.delay)

    def log(self, string):
        f = open(self.outfile, "a")
        f.write("[%s] : udpate (%s)\n" % (time.strftime("%Y/%m/%d %H:%M:%S"), string))
        f.close()

if __name__ == "__main__":
    feedupdate = FeedUpdate()
    feedupdate.update()

