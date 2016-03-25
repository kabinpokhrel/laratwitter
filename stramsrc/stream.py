from tweepy import Stream
from tweepy import OAuthHandler
from tweepy.streaming import StreamListener
import os, time, json, csv

#consumer key, consumer secret, access token, access secret.


class listener(StreamListener):

    def on_data(self, data):
        decoded_data = json.loads(data)
        try:
            tweet_id_str = decoded_data['id_str']
            user_screen_name = str(decoded_data['user']['screen_name'])
            tweet_text = str(decoded_data['text'].encode('ascii', 'ignore'))
            data_to_write = tweet_id_str + "," + user_screen_name
            print("tweet:{} from: {}".format(tweet_text,data_to_write))
            saveFile = open('datasets/db.csv', 'a')
            saveFile.write(data_to_write)
            saveFile.write('\n')
            saveFile.close()

        except BaseException as e:
            print('failed ondata,', str(e))
            time.sleep(5)
    def on_error(self, status):
        print(status)

auth = OAuthHandler(ckey, csecret)
auth.set_access_token(atoken, asecret)

twitterStream = Stream(auth, listener())

twitterStream.filter(track = ['hello there'], locations = [-122.75,36.8,-121.75,37.8])