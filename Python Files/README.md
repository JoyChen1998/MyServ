### Guide for Compare.py

#### class `JudgeSameFiles`

+ 其中包含
```python
#1.记录每个文件的大小信息
def RecordMessage(path)
	
#2.比较文件大小
def CompareFileSize(path)
	
#3.判重
def DifferCopyFile(path)

#4.解压并格式化docx文档  ## 用作文档简单的比对
def FormatDocxFile(path)

#5.解压包
def unzipFile(path)
	 
#6.保存代码文件到临时目录
def CodeSaveToTmpDir(path)
```
+ 需要注意
1. 压缩包的格式应该为:`stuid_proj.zip`, 例子:`201612345678_123.zip`, 长度最长不超过22.
2. 在复制文件或者解压时,可能需要root等权限.
3. 设置好要判重的目录,尽量为英文路径.
4. 规范化好压缩包.、
5. 依赖模块`difflib`,没有的话请自行下载.


+ 执行脚本时的方法顺序大致为:
1. 
```python 
unzipfile(full_path)
```
解压包.这里会将压缩包全部解压,并将需要判重的文件类型`allowType`全部合并并保存为`stuid_proj.txt`,放在解压后的原路径中.
2. 
```python
CodeSaveToTmpDir(full_path)
```
只会将代码的txt文件保存到tmp_dir中. 应该注意，这里需要提前设置临时路径.
3. 
```python
RecordMessage(path)
```
记录所有人的project的大小信息,会生成一个`recordfile`.txt 文件记录.
4.  
```python
def CompareFileSize(path)
```
只比较代码文件大小是否完全相同,并生成一个`sameSizefile.txt`.//用来判别一模一样的项目.
5. 
```python
def DifferCopyFile(path)
```
比较代码txt文件的相同串. 请自行设置判重比例`default_ratio`.对比结束后会生成一个`similarfiles`.txt, 记录重复度大于判重比例的`stuid_proj`.//判重
