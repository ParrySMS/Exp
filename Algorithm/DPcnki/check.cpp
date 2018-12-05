#include <algorithm>
#include "iomanip"
#include <fstream>
#include <vector>
#include <iostream>
#include <string>
#include <cstring>
using namespace std;

//var`
#define FILE1 "B2.txt"
#define FILE2 "A2.txt"

//#define FILE1 "test1.txt"
//#define FILE2 "test2.txt"

const float SIMIRATIO = 0.70; //the params r
const int LINES = 500;//max limited lines number

const bool SHOW_LINE_COMPARE = false;
const bool SHOW_DIJ = false;
const bool SHOW_LCS_TABLE_OF_LINE = false;
const bool SHOW_LCS_TABLE_OF_PART = false;

class Text {

	private:

		ifstream in;

	public:
		int file_lines;
		vector <string>  file;

		Text(string filename) {
			file_lines = 0;
			if(!openFile(filename)) {
				in.close();
			} else {
				readFile();
			}
		};

		~Text() {
			file_lines = 0;
			in.close();
		};

		bool openFile(string filename) {
			in.open(filename.data());

			if (!in.is_open()) {
				cout <<"ERROR: no such file" << endl;
				return false;
			}

			cout <<"File: ["<<filename<<" ] open"<< endl;
			return true;
		}

		void readFile() {
			string line ;

			while (!in.eof()) {
				if(getline(in, line)) {

//				cout<<"line:"<<line<<endl;

					file.push_back(trim(line));

					file_lines++;

				} else {
					break;
				}
			}

			in.close();
		}

		//去掉字符串中的全部空格
		string& trim(string &str) {
			int index = 0;
			if( !str.empty()) {
				while( (index = str.find(' ',index)) != string::npos) {
					str.erase(index,1);

				}

			}

			return str;
		}

};


//function
float getSimi(string line_a,string line_b);
inline int getDij(float,float);
int getRepeatedNum(int** mx_d,int len);
void trim(string &str);

//implement
inline int getDij(float s,float r = SIMIRATIO) {
	return s>r?1:0;
}


float getSimi(string line_a,string line_b) {
	int len_a,len_b,i,j,min;
	int** mx_len; //matrix of len
	int** mx_step; //matrix of step dirction to subproblem
	//mx_step[][] null:-1  left&&up:0 ,left:1 ,up:2, left||up:3
	//                 \ 00    ←01    ↑10    ←↑11

	len_a = line_a.length();
	len_b = line_b.length();

	//init mx
	mx_len = new int* [len_a+1];//line
	mx_step = new int* [len_a+1];//line

	for(i=0; i<len_a+1; i++) {//col
		mx_len[i] = new int [len_b+1]();
		mx_step[i] = new int [len_b+1]();
	}

	//count 2 line
	for(i=0; i<len_a+1; i++) {
		for(j=0; j<len_b+1; j++) {

			if(i==0||j==0) { //one of 0 , edge of mx
				mx_len[i][j] = 0;
				mx_step[i][j] = -1;
				continue;
			}

			//[Notice]: line make it start as 1 to n
			//not edge
			if(line_a[i-1] == line_b[j-1]) { // match,  subproblem len add 1
				mx_len[i][j] = mx_len[i-1][j-1] + 1;
				mx_step[i][j] = 0; // ↖
				continue;
			}

			//not match get max{ [i-1,j], [i,j-1] }
			//              cut line_a  OR  cut line_b

			if(mx_len[i-1][j] == mx_len[i][j-1]) {	//cut line_a  OR  cut line_b  both ok
				mx_len[i][j] = mx_len[i-1][j];
				mx_step[i][j] = 3; // ←↑

			} else if(mx_len[i-1][j] > mx_len[i][j-1]) { //cut line_a
				mx_len[i][j] = mx_len[i-1][j];
				mx_step[i][j] = 1; // ←

			} else { //mx_len[i-1,j] < mx_len[i,j-1]
				//cut line_b
				mx_len[i][j] = mx_len[i][j-1];
				mx_step[i][j] = 2; // ↑
			}

		}//for j
	}//for i
	//end count 2 line

	//echo mx_len
	if(SHOW_LCS_TABLE_OF_LINE) {

		for(i=0; i<len_a+1; i++) {
			for(j=0; j<len_b+1; j++) {
				cout<<"len["<<i<<"]";
				cout<<"["<<j<<"]";
				cout<<":"<<mx_len[i][j]<<endl;

				cout<<"step["<<i<<"]";
				cout<<"["<<j<<"]";
				cout<<":"<<mx_step[i][j]<<endl;
				
				cout<<endl;
			}
		}
	}

	min = len_a > len_b ? len_b : len_a;

//	cout<<"LCS:"<<mx_len[len_a][len_b]<<endl;
//	cout<<"min:"<<min<<endl;

	return min == 0? 0 : ((float)mx_len[len_a][len_b])/min;
}


int getRepeatedNum(int** mx_d,int numLine,int numCol) {
	int line,i,j;
	//consider line as a char
	// ,then [ part = many lines]
	// is similar to [string = many char]

	int** mx_len; //matrix of len
	int** mx_step; //matrix of step dirction to subproblem
	//mx_step[][] null:-1  left&&up:0 ,left:1 ,up:2, left||up:3
	//                 \ 00    ←01    ↑10    ←↑11

	//init mx
	mx_len = new int* [numLine+1];//line
	mx_step = new int* [numLine+1];//line

	for(i=0; i<numLine+1; i++) {//col
		mx_len[i] = new int [numCol+1]();
		mx_step[i] = new int [numCol+1]();
	}

	//count 2 part
	for(i=0; i<numLine+1; i++) {
		for(j=0; j<numCol+1; j++) {

			if(i==0||j==0) { //one of 0 , edge of mx
				mx_len[i][j] = 0;
				mx_step[i][j] = -1;
				continue;
			}

			//[Notice]: line make it start as 1 to n
			//not edge
			//the only differnt is match cond change,others is same to LCS
			if( mx_d[i-1][j-1] == 1) { // match,  subproblem len add 1
				mx_len[i][j] = mx_len[i-1][j-1] + 1;
				mx_step[i][j] = 0; // ↖
				continue;
			}

			//not match get max{ [i-1,j], [i,j-1] }
			//              cut line_a  OR  cut line_b

			if(mx_len[i-1][j] == mx_len[i][j-1]) {	//cut line_a  OR  cut line_b  both ok
				mx_len[i][j] = mx_len[i-1][j];
				mx_step[i][j] = 3; // ←↑

			} else if(mx_len[i-1][j] > mx_len[i][j-1]) { //cut line_a
				mx_len[i][j] = mx_len[i-1][j];
				mx_step[i][j] = 1; // ←

			} else { //mx_len[i-1,j] < mx_len[i,j-1]
				//cut line_b
				mx_len[i][j] = mx_len[i][j-1];
				mx_step[i][j] = 2; // ↑
			}

		}//for j
	}//for i
	//end count 2 line


	//echo mx_len
	if(SHOW_LCS_TABLE_OF_PART) {

		for(i=0; i<numLine+1; i++) {
			for(j=0; j<numCol+1; j++) {
				cout<<"len["<<i<<"]";
				cout<<"["<<j<<"]";
				cout<<":"<<mx_len[i][j]<<endl;

				cout<<"step["<<i<<"]";
				cout<<"["<<j<<"]";
				cout<<":"<<mx_step[i][j]<<endl;
			}
		}
	}
	
	
	return mx_len[numLine][numCol];
}

//main
int main() {
	Text* text1 = new Text(FILE1);
	Text* text2 = new Text(FILE2);
	string line_a,line_b;
	int ** mx_d;
	int i,j;

	//init mx
	mx_d = new int* [text1->file_lines];//line
	for(i=0; i<text1->file_lines; i++) {//col
		mx_d[i] = new int [text2->file_lines]();//text2
	}

	cout<<"file1-line:"<<text1->file_lines<<endl;
	cout<<"file2-line:"<<text2->file_lines<<endl;

	for(i=0; i<text1->file_lines; i++) {  //Ai
		line_a = (string)text1->file[i];

		for(j=0; j<text2->file_lines; j++) { //Bj
			line_b = (string)text2->file[j];

			float s;
			s = getSimi(line_a,line_b);
			mx_d[i][j] = getDij(s);

			if(SHOW_LINE_COMPARE) {

				cout<<"la:"<<line_a<<endl;
				cout<<"lb:"<<line_b<<endl;

				cout<<"["<<i<<"]";
				cout<<"["<<j<<"]";
				cout<<" s: "<<s<<endl<<endl;

			}
		}
	}

	if(SHOW_DIJ) {
		cout<<"D[][]"<<endl;
		for(i=0; i<text1->file_lines; i++) {  //Ai
			for(j=0; j<text2->file_lines; j++) { //Bj
				cout<<mx_d[i][j]<<"  ";
			}
			cout<<endl;
		}
	}


	cout<<"Repeated-Line-Num:"<<getRepeatedNum(mx_d,text1->file_lines,text2->file_lines)<<endl;

	text1->~Text();
	text2->~Text();
	delete []text1;
	delete []text2;

	return 0;
}