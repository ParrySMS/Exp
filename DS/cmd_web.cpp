
#include <iostream>
#include <stack>

using namespace std;

int main() {
	stack<string> Front;
	stack<string> Back;
	string cmd,url="http://www.acm.org/";
	while(cin>>cmd && cmd!="QUIT") {
		
		if(cmd=="VISIT") {
			Back.push(url);
			cin>>url;
			cout<<url<<endl;
			
			while(!Front.empty()){
				Front.pop();
			}
				
		} else if(cmd=="BACK") {
			
			if(Back.empty()) {
				cout<<"Ignored"<<endl;
			} else {
				Front.push(url);
				url=Back.top();
				Back.pop();
				cout<<url<<endl;
			}
			
		} else if(cmd=="FORWARD") {
			
			if(Front.empty()) {
				cout<<"Ignored"<<endl;
			} else {
				Back.push(url);
				url=Front.top();
				Front.pop();
				cout<<url<<endl;
			}
		}
	}
	return 0;
}
