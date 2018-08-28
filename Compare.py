import shutil
import difflib as df
import os
# import docx
import os.path
from zipfile import ZipFile

tmp_dir = '\_temp\\'
recordfile = 'record.txt'  # record submit files message
sameSizefile = 'same_size_file.txt'  # record same_size files
similarfiles = 'similar_file.txt'  # record differ files
allowType = ['c', 'cpp', 'h', 'java']  # Code Type
files = []  # all files
filesize = []  # file_size
classmates = []  # file_id
sizefiles = []  # record files' size
forospath = []  #
record = {}  # record dic
dir_files = []  # files in dir
code_files = []  # code files
default_ratio = 0.6  # default differ ratio
unzipList = []  # for unzip & rename
new_path = 'your new directory'
#
class JudgeSameFiles:
    @staticmethod
    def RecordMessage(PATH):
        if os.path.exists(PATH):
            open(PATH + recordfile, 'w').write("file_name" + "   " + "size(byte)" + "\n")
            filerecord = open(PATH + recordfile, 'a')
            print("Now recording files .")
            for i in os.listdir(PATH):
                print(".")
                stu_id = i.split('.')[0].strip()
                if stu_id == 'record' or stu_id == 'same_size_file' or stu_id == 'similar_file':
                    continue
                size = os.path.getsize(PATH + i)
                filerecord.write(" " + str(stu_id) + '\t\t\t\t' + str(size) + "\n")
                filesize.append(size)
                classmates.append(stu_id)
                files.append(i)
            # record = dict(zip(classmates, filesize))
            # print(record)
            filerecord.close()
            print()
            print("record files Complete!")
        else:
            print("Dir `" + PATH + "` does not exist!")
        return

    @staticmethod
    def CompareFileSize(PATH):
        if os.path.exists(PATH):
            open(PATH + sameSizefile, 'w').write("file_size equals' student" + "\n\n")
            equalrecord = open(PATH + sameSizefile, 'a')
            print("Now Comparing files' size .")
            for i in range(len(filesize)):
                for j in range(i + 1, len(filesize)):
                    if filesize[j] == filesize[i]:
                        print(".")
                        sizefiles.append(files[j])
                        equalrecord.write(str(classmates[j]) + '\t\t\t\t' + classmates[i] + "\n")
            equalrecord.close()
            # print(copyfiles)
            print()
            print("Compare files' size complete!")
        else:
            print("Dir `" + PATH + "` does not exist!")
        return

    @staticmethod
    def DifferCopyFile(PATH):
        if os.path.exists(PATH):
            open(PATH + similarfiles, 'w').write("similar files' students" + "\n\n")
            smlrfiles = open(PATH + similarfiles, 'a')
            # PATH += tmp_dir   pri for docx
            print("Now Checking ...")
            for i in os.listdir(PATH):
                print(i)
                if i == recordfile or i == sameSizefile or i == similarfiles:
                    continue
                rd = open(PATH + i, 'rb')
                forospath.append(rd.read().strip())
                rd.close()
            print("Now Comparing ...")
            num = 0
            for m in range(len(forospath)):
                for n in range(m + 1, len(forospath)):
                    num = num + 1
                    print('已经Compare ', str(num), '次')
                    cpyradio = df.SequenceMatcher(None, forospath[n], forospath[m]).ratio()
                    if cpyradio > default_ratio:
                        smlrfiles.write(classmates[m] + '\t\t\t\t' + classmates[n] + '\t\t' + str(cpyradio) + "\n")
            smlrfiles.close()
            # shutil.rmtree(PATH)
            print()
            print("Check & Compare Finished!")
        else:
            print("Dir `" + PATH + "` does not exist!")
        return

    @staticmethod
    # def FormatDocxFile(root):
    #     global new_path
    #     if os.path.exists(root):
    #         new_path = root + tmp_dir
    #         if os.path.exists(new_path):
    #             shutil.rmtree(new_path)
    #         os.mkdir(new_path)  # create temp dir for check
    #         for i in os.listdir(root):
    #             if i.split('.')[-1] == 'docx':
    #                 docx_file = docx.Document(root + i)
    #                 for j in range(len(docx_file.paragraphs)):
    #                     text = docx_file.paragraphs[j].text
    #                     open(new_path + i.replace('docx', 'txt'), 'a', encoding='utf-8').write(text)
    #     return new_path

    @staticmethod
    def unzipFile(root):
        if os.path.exists(root):
            for dirpath, dirnames, filenames in os.walk(root):
                for filename in filenames:
                    if len(filename) < 22:
                        NAME = filename.split('.')[0]
                        name = dirpath + '\\' + str(NAME)
                        try:
                            with ZipFile(dirpath +'\\' + filename, 'r') as zp:
                                print(filename, 'Extracting all the files now...')
                                zp.extractall(path=name)
                                print('done!')
                                zp.close()
                                dirx = name
                                print(dirx)
                                for dirpath1, dirnames1, filenames1 in os.walk(dirx):
                                    for filename1 in filenames1:
                                        if filename1.split('.')[-1] in allowType:
                                            portion = os.path.splitext(filename1)
                                            newname = portion[0] + '.txt'
                                            print(dirpath1 + '\\' + filename1)
                                            os.rename(dirpath1 + '\\' + filename1, dirpath1 + '\\' + newname)
                                            print(filename1)
                                for dirpath2, dirnames2, filenames2 in os.walk(dirx):
                                    for filename2 in filenames2:
                                        if filename2.split('.')[-1] == 'txt':
                                            with open(dirpath2 + '\\' + filename2, 'rb') as f1:
                                                with open(root + '\\' + NAME + '.txt', 'ab+') as f2:
                                                    f2.write(f1.read())
                        except:
                            print(filename, ' 解压失败')
        else:
            print('Error : Empty Zip dir')
        return

    @staticmethod
    def CodeSaveToTmpDir(root):
        global new_path
        if os.path.exists(root):
            new_path = root + tmp_dir
            if os.path.exists(new_path):
                shutil.rmtree(new_path)
            os.mkdir(new_path)
            print(new_path)
            for file in os.listdir(root):
                if file.split('.')[-1] == 'txt':
                    shutil.copy(root+'/'+file, new_path + '/' + file)

        else:
            print('Error :can not do filter!')
test = JudgeSameFiles()
test.unzipFile(new_path)
ps = 'your directory'
test.CodeSaveToTmpDir(new_path)
test.RecordMessage(ps)
test.CompareFileSize(ps)
test.DifferCopyFile(ps)
