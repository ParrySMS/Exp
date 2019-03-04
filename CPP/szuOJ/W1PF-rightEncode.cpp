#include <stdio.h>
#include <string>
#include <iostream>
using namespace std;
void rightEncode(string s) ;
int main() {
	int i,j,t,n,m;

	cin>>t;
	while(t--) {
		string s("");
		cin>>s;

		rightEncode(s);
	}
	return 0;
}

void rightEncode(string s) {
	int i,len;
	len = s.size();
	for(i=0; i<len; i++) {
		if(s[i]>='a'&& s[i]<='z'
		        ||s[i]>='A'&& s[i]<='Z') {
			s[i]+=4;
	
			if(s[i]>'Z' && s[i]<'a'
			        || s[i]>'z') {
				s[i]-=26;
			}
		}
	}
	cout<<s<<endl;
}
