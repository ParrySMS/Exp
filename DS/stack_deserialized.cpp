#include <iostream>
#include <stack>
using namespace std;

int main ()
{
  stack<char> s;
	int i,j,t,len;
	string str;
	
	cin>>t;
	for(i=0;i<t;i++){
		cin>>str;
		
		len = str.length(); 
		for(j=0;j<len;j++){
			s.push(str[j]);
		}
		
		while(!s.empty()){
			cout<<s.top();
			s.pop();
		}
		cout<<endl;
	
	}
}
