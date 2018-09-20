#include <iostream>
#include <stack>
using namespace std;

char getMatchedLeftChar(char c) {
	switch(c) {
//		case '{':
//			return '}';
//		case '[':
//			return ']';
//		case '(':
//			return ')';

		case ')':
			return '(';
		case ']':
			return '[';
		case '}':
			return '{';
		default:
			return ' ';
	}
}

int main () {
	char getMatchedLeftChar(char c) ;
	stack<char> s;
	int i,j,t,len;
	string str;

	cin>>t;
	for(i=0; i<t; i++) {
		cin>>str;

		len = str.length();

		//in stack
		for(j=0; j<len; j++) {
			switch(str[j]) {
				case '{':
				case '[':
				case '(':
					s.push(str[j]);
					break;

				default:
					if(!s.empty()&&s.top()==getMatchedLeftChar(str[j])) {
						s.pop();
					}
			}

		}//end in

		//cout
		if(s.empty()) {
			cout<<"ok";
		} else {
			cout<<"error";
		}
		
		//clear
		while(!s.empty()) {
			s.pop();
		}


		cout<<endl;
	}
}
