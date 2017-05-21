'''
Esanin News
Created By: Sidath Gajanayaka, Malitha Sakalasooriya
Date: 10th of April 2017
Last edited date: 25th of April 2017
(C) All rights reserved.
'''

# Function to fetch the rss feed and return the parsed RSS
import feedparser
from bs4 import BeautifulSoup
import urllib

cleantext=[]
# A list to hold all headlines
all_headlines = []

def parseRSS(rss_url):
    return feedparser.parse(rss_url)

# Function grabs the rss feed headlines (titles) and returns them as a list
def getHeadlines(rss_url):
    headlines = []
    feed = parseRSS(rss_url)
    for newsitem in feed['items']:
        headlines.append(newsitem['link'])
    return headlines

def getNews():
    try:
        # List of RSS feeds that we will fetch and combine
        newsurls = {
            'dailynews': 'http://www.dailymirror.lk/RSS_Feeds/business-main'
        }

        # Iterate over the feed urls
        for key, url in newsurls.items():
            all_headlines.extend(getHeadlines(url))

        # Iterate over the allheadlines list and print each headline
        for hl in all_headlines:
            try:
                html_text = urllib.urlopen(hl).read()
                parsed_text = BeautifulSoup(html_text, "html.parser")
                desc = parsed_text.findAll(attrs={"class": "row inner-text"})
                #print desc
                content_news = desc[0].encode('utf-8')
                para = str(content_news).split("<p>")
                final_string = ""
                for a in para:
                    if "img" in a or "iframe" in a or "!--" in a:
                        pass
                    else:
                        final_string = final_string + a
                append_string = BeautifulSoup(final_string, "html.parser").text
                printLog('info', "News item: " + append_string.strip())
                cleantext.append(append_string)
            except Exception as e:
                print e
        printLog('output', "Parsed text: " + str(cleantext))
        return cleantext
    except Exception as e:
        printLog('error', e)

def printLog(level, message):
    if level == 'info':
        print "[INFO]: ", message
    elif level=='error':
        print "[ERROR]: ", message
    elif level == 'process':
        print "[PROCESS]: ", message
    elif level == 'output':
        print "[OUTPUT]: ", message