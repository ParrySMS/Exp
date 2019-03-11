#include <iostream>
#include <iomanip>
using namespace std;

int compare(char *S, char *T) {
	int i,s_num = 0,t_num=0;

	for(i=0; S[i]!='\0'&&T[i]!='\0'; i++) {
		if((S[i] - T[i])>0) {
			s_num++;
		} else if((S[i] - T[i])<0) {
			t_num++;
		}
	}

//	cout<<"s:"<<s_num<<endl;
//	cout<<"t:"<<t_num<<endl;
//	cout<<S[i]<<endl;
//	cout<<T[i]<<endl;
//╬Ь╤тсеох
	if(S[i]!='\0'&& T[i] =='\0') {
		return 1;
	}

	if(S[i]=='\0' && T[i] !='\0') {
		return -1;
	}

	if(t_num==s_num) {
		return 0;
	}
	if(t_num<s_num) {
		return 1;
	}
	if(t_num>s_num) {
		return -1;
	}
}
int main() {
	int t;

	cin>>t;
	while(t--) {
		char *word1 = new char[255];
		char *word2 = new char[255];
		cin>>word1>>word2;
		cout<<compare(word1,word2)<<endl;
		delete []word1;
		delete []word2;

	}
	return 0;
}
