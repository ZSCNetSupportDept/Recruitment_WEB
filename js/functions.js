var REGEX_NAME = /^[\u4E00-\u9FA5]{2,10}$/;
var REGEX_PHONE =  /^1[34578]\d{9}$/;
var REGEX_EMAIL = /^[-\w.%+]+@([-\w%+]+\.)+[a-z]+$/i;
var REGEX_FACULTY = /^(电子信息|机电工程|计算机|材料与食品|人文社会科学|管理|经贸|外国语|艺术设计)学院$/;
var REGEX_CLASS = /^(应用化学|食品质量与安全|环境工程|生物制药|材料科学与工程|通信工程|通信工程（2\+2）|电子科学与技术|电子科学与技术（2\+2）|光电信息科学与工程|电子信息工程|工商管理|物流管理|财务管理|人力资源管理|机械设计制造及其自动化|自动化|自动化（2\+2）|电气工程及其自动化|计算机类|计算机科学与技术（2\+2）|电子商务|金融学|国际经济与贸易|会展经济与管理|法学|旅游管理|新闻学|行政管理|翻译|英语|商务英语|日语|工业设计|动画|设计学类)?$/;
var REGEX_NUMBER = /^2018\d{9}$/;
var REGEX_MARK = /^\d{10}$/;

function check() {
    var inputs = document.getElementsByClassName("input");
    var hints = document.getElementsByClassName("hint");
    var ERRORS = ["姓名", "手机号", "邮箱", "学院名称", "专业", "学号"];
    var REGEXS = [REGEX_NAME, REGEX_PHONE, REGEX_EMAIL, REGEX_FACULTY, REGEX_CLASS, REGEX_NUMBER, REGEX_MARK];
    var ret = true;

    for (var i = 0; i < 6; i++) {
        if (REGEXS[i].test(inputs[i].value) === false) {
            ret = false;
            hints[i].innerText = "请不要输入奇怪的" + ERRORS[i] + "哦~";
        } else {
            hints[i].innerText = "";
        }
    }

    return ret;
};

/*  */

var faculty = ["电子信息学院", "机电工程学院", "计算机学院", "材料与食品学院", "人文社会科学学院", "管理学院", "经贸学院", "外国语学院", "艺术设计学院"];
var ClassName= [
   /*电子*/ ["通信工程","通信工程（2+2）","电子科学与技术","电子科学与技术（2+2）","光电信息科学与工程","电子信息工程"],
   /*机电*/ ["机械设计制造及其自动化","电气工程及其自动化","自动化（2+2）","自动化"],
   /*计机*/ ["计算机类","计算机科学与技术（2+2）"],
   /*材食*/ ["应用化学","材料科学与工程","环境工程","生物制药","食品质量与安全"],
   /*人文*/ ["会展经济与管理","法学","旅游管理","行政管理","新闻学"],
   /*管理*/ ["财务管理","工商管理","物流管理","人力资源管理"],
   /*经贸*/ ["金融学","国际经济与贸易","电子商务"],
   /*外语*/ ["英语","商务英语","日语","翻译"],
   /*艺术*/ ["工业设计","设计学类","动画"],
    ];


function getClassName(){
    var faculty_name = document.Data.faculty;
    var class_name = document.Data.class;
    var faculty_class = ClassName[faculty_name.selectedIndex - 1];
    class_name.length = 1;
    for (var i = 0 ; i < faculty_class.length; i++){
        class_name[i + 1] = new Option(faculty_class[i],faculty_class[i]);
    }
}

function getCookie(key) {
    if (document.cookie.length) {
        var start = document.cookie.indexOf(key + "=");
        if (~start) {
            start += key.length + 1;
            var end = document.cookie.indexOf(";", start);
            if (end === -1)
                end = document.cookie.length;
            return document.cookie.substring(start, end);
        }
    }
    return "";
}