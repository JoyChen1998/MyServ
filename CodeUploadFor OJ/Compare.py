import difflib as df
import os
import os.path
rootdir = 'F:/WAMP/wamp/www/'                                                           #根目录
nextdir = ['justforcheck1/', 'justforcheck2/']                                          #子目录
recordfile = 'record.txt'                                                               #记录提交文档的文件
sameSizefile = 'same_size_file.txt'                                                     #记录相同大小的文件
similarfiles = 'similar_file.txt'                                                       #记录相似的文件
files = []                                                                              #所有文件
filesize = []                                                                           #文件大小
classmates = []                                                                         #文档名字
sizefiles = []                                                                          #相同尺寸文件
forospath = []                                                                          #文件二进制内容
record = {}                                                                             #记录所有提交的字典
#
class JudgeSameFiles:
    def RecordMessage(self):
        if os.path.exists(rootdir+nextdir[0]):
            open(rootdir + recordfile, 'w').write("stu_name"+"   "+"size(byte)"+"\r\n")
            filerecord = open(rootdir+recordfile, 'a')
            for i in os.listdir(rootdir+nextdir[0]):
                stu_id = i.split('.')[0].strip()
                size = os.path.getsize(rootdir+nextdir[0]+i)
                filerecord.write(" "+stu_id+"        "+str(size)+"\r\n")
                filesize.append(size)
                classmates.append(stu_id)
                files.append(i)
            record = dict(zip(classmates, filesize))
            # print(record)
            filerecord.close()
        else:
            print("Dir `"+rootdir+nextdir[0]+"` does not exist!")
        return
    def CompareFileSize(self):
        if os.path.exists(rootdir+nextdir[0]):
            open(rootdir+sameSizefile, 'w').write("file_size equals' student"+"\r\n\r\n")
            equalrecord = open(rootdir+sameSizefile, 'a')
            for i in range(len(filesize)):
                for j in range(len(filesize)):
                    if filesize[j] == filesize[i] and j > i:
                        sizefiles.append(files[j])
                        equalrecord.write(str(classmates[j])+"          "+classmates[i]+"\r\n")
            equalrecord.close()
            # print(copyfiles)
        else:
            print("Dir `"+rootdir+nextdir[0]+"` does not exist!")
        return
    def DifferCopyFile(self):
        if os.path.exists(rootdir + nextdir[0]):
            open(rootdir+similarfiles, 'w').write("similar files' students"+"\r\n\r\n")
            smlrfiles = open(rootdir+similarfiles, 'a')
            for i in os.listdir(rootdir+nextdir[0]):
                # print(i)
                rd = open(rootdir+nextdir[0]+i, 'rb')
                forospath.append(rd.read().strip())
                rd.close()
            for m in range(len(forospath)):
                for n in range(len(forospath)):
                    if df.SequenceMatcher(None, forospath[n], forospath[m]).ratio() == 1 and n > m:
                        smlrfiles.write(classmates[m]+"         "+classmates[n]+"\r\n")
            smlrfiles.close()
        else:
            print("Dir `"+rootdir+nextdir[0]+"` does not exist!")
        return
# comp = JudgeSameFiles()
# comp.RecordMessage()
# choose = 1
# if choose == 1:
#     comp.DifferCopyFile()
# elif choose == 2:
#     comp.CompareFileSize()
