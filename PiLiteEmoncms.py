#!/usr/bin/env python
import urllib

from PiLiteLib import PiLiteBoard, poll_for_updates, JSONPoll, CyclingSources


class EmoncmsPoll(JSONPoll):
    def __init__(self, location, message_format=""):
        """ Replace SERVER and APIKEY with your values """
        default_format = "{name}: {value}"
        base_url = "http://SERVER/feed/get.json?id=%s&apikey=APIKEY"
        super(EmoncmsPoll, self).__init__(base_url%location,
                                          message_format or default_format)

    def mung_data(self,data):
        """ Limit non-integers to 1 decimal place """
        if len((data['value']).split('.')) > 1:
           data['value'] = round(float(data['value']),1)

        return super(EmoncmsPoll, self).mung_data(data)

def main():
    """ Which feeds to use, example is 1, 6, 28 and 3 """
    source = CyclingSources(EmoncmsPoll("1"),
               EmoncmsPoll("6"),
               EmoncmsPoll("28"),
               EmoncmsPoll("3"))
    sink = PiLiteBoard()
    print("ready")
    sink.write("ready  ")
    """ 15 in the line below is the interval between each data feed/display cycle """
    poll_for_updates(source, sink, 15)


if __name__ == "__main__":
    main()

