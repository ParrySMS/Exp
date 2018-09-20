#include <iostream>
#include <stack>
using namespace std;

int main () {
	stack<char> s,backward;
	int i,j,t,len;
	string str;

	cin>>t;
	for(i=0; i<t; i++) {
		cin>>str;

		len = str.length();
		//cin
		for(j=0; j<len; j++) {
			if(str[j]=='#') {
				if(!s.empty()) {
					s.pop();
				}
				continue;
			}
			//no #
			s.push(str[j]);


		}//end cin
		
		//cout
		while(!s.empty()) {
			backward.push(s.top());
			s.pop();
		}
		
		if(backward.empty()){
			cout<<"NULL";
		}
		
		while(!backward.empty()) {
			cout<<backward.top();
			backward.pop();
		}
		
		
		cout<<endl;
	}
}
