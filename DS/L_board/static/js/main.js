var board = [];
var score = 0;
var hasConflicted = [];

var n = getQueryString('k');
var d = getQueryString('d');

var randx = 0;
var randy = 0;

var pieces = [];
var len;
var index = 0;

var delay = 1000;
if(d!=null){
    delay = d;
}
$(document).ready(function () {
    prepareForMobile();
    //初始化棋盘格
    init();
    //后端决定随机位置
    // selectOne();


});

function startCover() {
    //发送请求
    var url = './static/getResp.php?size=' + n;
    $.getJSON(url, function (data) {
        // alert("Data Loaded: " + data);

        //第一个随机初始位置
        var xi = data.initial_occupied_block.row;
        var yi = data.initial_occupied_block.col;
        showNumberWithAnimation(xi, yi, "white");

        pieces = data.pieces;
        len = pieces.length;
        // alert("len: " + len);
        //延迟放置L星块
        setTimeout("setLBlocks()", delay);

    });
}

//放置L块
function setLBlocks() {
    var i = index;
    index++;
    // alert("setB i: " + i);
    var x0 = this.pieces[i].loc[0].row;
    var y0 = pieces[i].loc[0].col;
    var x1 = pieces[i].loc[1].row;
    var y1 = pieces[i].loc[1].col;
    var x2 = pieces[i].loc[2].row;
    var y2 = pieces[i].loc[2].col;
    var co = getRandomColor();
    showNumberWithAnimation(x0, y0, co);
    showNumberWithAnimation(x2, y2, co);
    showNumberWithAnimation(x1, y1, co);
    if (i < len - 1) {
        setTimeout("setLBlocks()", delay);
    }
}

//随机颜色
function getRandomColor() {
    // return '#'+Math.floor(Math.random()*256).toString(10);

    var r = Math.floor(70+Math.random() * 200);
    var g = Math.floor(Math.random() * 250);
    var b = Math.floor(Math.random() * 250);

    return "rgb(" + r + ',' +g + ',' + b + ")";
    // return '#' + ('00100' + (Math.random() * 0x1000000 << 0).toString(16)).substr(-6);
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


function init() {

    if (n == null) {
        n = Math.pow(2, 3);
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
        board[i] = [];
        hasConflicted[i] = [];
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

//随机生成一个位置
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

function showNumberWithAnimation(i, j, color) {

    var numberCell = $('#number-cell-' + i + "-" + j);

    numberCell.css("background-color", color)
    numberCell.css("color", color)
    // numberCell.text(getNumberText(randNumber))

    numberCell.animate({
        width: cellSideLength,
        height: cellSideLength,
        top: getPosTop(i, j),
        left: getPosLeft(i, j)
    }, 50);
}

documentWidth = window.screen.availWidth;
gridContainerWidth = 0.92 * documentWidth;
cellSideLength = 0.18 * documentWidth;
cellSpace = 0.04 * documentWidth;


function getPosTop(i, j) {
    return cellSpace + i * (cellSpace + cellSideLength);
}

function getPosLeft(i, j) {
    return cellSpace + j * (cellSpace + cellSideLength);
}
