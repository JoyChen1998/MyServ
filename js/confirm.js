function confirmsub() {
    var getfilemsg = document.getElementById("p").value;
    getfilemsg = getfilemsg.substring(12, getfilemsg.length);
    var len = getfilemsg.length;
    var defalt_file_suffix = 'zip';
    var start = getfilemsg.lastIndexOf('.')+1, end =getfilemsg.length;
    var suffix = getfilemsg.substring(start, end);
    if(suffix != defalt_file_suffix){
        alert('上传文件类型错误!');
        return false;
    }
    return confirm('你提交的文件名为 '+getfilemsg+'\n确定提交?');
}
