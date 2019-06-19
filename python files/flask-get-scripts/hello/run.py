from GetJdComment import GetJdComment
import argparse

parser = argparse.ArgumentParser()
parser.add_argument('-i', '--item', help='search item', type=str)
parser.add_argument('-v', '--value', help='goods id', type=str)
args = parser.parse_args()

gt = GetJdComment()
if args.item:
    gt.find_goods_item(args.item)
elif args.value:
    gt.get_comment(args.value)
gt.end_phase()