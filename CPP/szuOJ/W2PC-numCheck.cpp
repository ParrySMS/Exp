#include <iostream>
#include <iomanip>
using namespace std;

int isNumber(char * str) {
	int i,num = 0;
	for(i=0; str[i]!='\0'; i++) {
		if((str[i] - '0')>9 || (str[i] - '0')<0) {
			return -1;
		} else {
			num*=10;
			num = num+ (str[i] - '0');
		}
	}
	return num;
}

int main() {
	int t;
	cin>>t;

	while(t--) {
		char *word = new char[255];
		cin>>word;
		cout<<isNumber(word)<<endl;
		delete []word;
	}
	return 0;
}
