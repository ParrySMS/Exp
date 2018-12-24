var board = new Array();
var score = 0;
var hasConflicted = new Array();

var startx = 0;
var starty = 0;
var endx = 0;
var endy = 0;
var n = getQueryString('n');

var randx = 0;
var randy = 0;

$(document).ready(function () {
    prepareForMobile();
    //后端决定随机位置
    // selectOne();

})

function startCover() {
    var url = './testJson.php?size='+n;
    $.get(url, function (data) {


    });



}

//随机颜色
function getRandomColor() {
    return "hsb(" + Math.random() + ", 1, 1)";
}

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return null;
}

function prepareForMobile() {

    if (documentWidth > 500) {
        gridContainerWidth = 500;
        cellSpace = 20;
        cellSideLength = 100;
    }
    //
    $("#main").css("width", gridContainerWidth - 2 * cellSpace);
    $("#main").css("height", gridContainerWidth - 2 * cellSpace);
    $("#main").css("padding", cellSpace);
    $("#main").css("border-radius", 0.01 * gridContainerWidth);


    $(".main-box").css("width", cellSideLength);
    $(".main-box").css("height", cellSideLength);
    $(".main-box").css("border-radius", 0.01 * cellSideLength);
}

function selectOne() {
    //初始化棋盘格
    init();
    //随机生成一个位置
    generateOneNumber();
}

function init() {

    if (n == null) {
        n = Math.pow(2, 5);
    } else {
        n = Math.pow(2, n);
    }

    $("#main").css("width", 120 * n - 20);
    $("#main").css("height", 120 * n - 20);
    $("#main").css("padding", cellSpace);
    $("#main").css("border-radius", 0.01 * gridContainerWidth);

    for (var i = 0; i < n; i++) {
        for (var j = 0; j < n; j++) {
            var gridCell = $("#box-" + i + "-" + j)
            gridCell.css("top", getPosTop(i, j))
            gridCell.css("left", getPosLeft(i, j))
        }
    }

    for (var i = 0; i < n; i++) {
        board[i] = new Array();
        hasConflicted[i] = new Array();
        for (var j = 0; j < n; j++) {
            board[i][j] = 0;
            hasConflicted[i][j] = false;
        }
    }
    updateBoardView(n);

    score = 0;
}

function updateBoardView() {
    $(".number-cell").remove();
    for (var i = 0; i < n; i++) {
        for (var j = 0; j < n; j++) {
            $("#main").append('<div class="number-cell" id="number-cell-' + i + '-' + j + '"></div>')
            var theNumberCell = $('#number-cell-' + i + '-' + j)

            if (board[i][j] == 0) {
                theNumberCell.css({"width": "0", "height": "0"})
                theNumberCell.css("top", getPosTop(i, j) + cellSideLength / 2)
                theNumberCell.css("left", getPosLeft(i, j) + cellSideLength / 2)
            } else {
                theNumberCell.css('width', cellSideLength);
                theNumberCell.css('height', cellSideLength);
                theNumberCell.css('top', getPosTop(i, j));
                theNumberCell.css('left', getPosLeft(i, j));
                theNumberCell.css('background-color', getNumberBackgroundColor(board[i][j]));
                theNumberCell.css('color', getNumberColor(board[i][j]));

                theNumberCell.text(getNumberText(board[i][j]));

            }
            hasConflicted[i][j] = false;
        }
        $(".number-cell").css("line-height", cellSideLength + "px");
        $(".number-cell").css("font-size", 0.3 * cellSideLength + "px");
    }
}

function generateOneNumber() {
    if (nospace(board))
        return false;
    //随机一个位置
    randx = parseInt(Math.floor(Math.random() * n));
    randy = parseInt(Math.floor(Math.random() * n))

    var times = 0;
    while (times < 50) {
        if (board[randx][randy] == 0)
            break;

        randx = parseInt(Math.floor(Math.random() * n));
        randy = parseInt(Math.floor(Math.random() * n))

        times++;
    }
    if (times == 50) {
        for (var i = 0; i < n; i++)
            for (var j = 0; j < n; j++) {
                if (doard[i][j] == 0) {
                    randx = i;
                    randy = j;
                }
            }
    }
    //随机一个数字
    var randNumber = Math.random();
    //在随机的位置上显示
    board[randx][randy] = randNumber;
    showNumberWithAnimation(randx, randy, randNumber);
    return true;

}


function isgameover() {
    if (nospace(board) && nomove(board)) {
        gameover();
    }
}


function gameover() {
    $(".over").show();
    $(document).click(function () {
        $(".over").hide()
    })
}

$("#bot").click(function () {
    score = 0;
    updateScore(score)
})