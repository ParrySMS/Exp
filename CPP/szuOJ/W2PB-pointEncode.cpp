#include <iostream>
#include <iomanip>
using namespace std;


int main() {
	int i,t,key_index,word_index;
	char *word = new char[255];
	char *key = new char[255];
	char *crypt = new char[255];
	char ch;
	cin>>t;
	while(t--) {
		cin>>word>>key;

		for(word_index=0,key_index=0; word[word_index]!='\0'; word_index++,key_index++) {
			if(key[key_index]=='\0') {//back
				key_index = 0;
			}

			ch = word[word_index]+ key[key_index] - '0';//char couter
			if(ch > 'z' || ch>'Z'&&ch<'a') {
				ch = ch-26;
			}
			crypt[word_index] = ch;
		}

		for(word_index=0; crypt[word_index]!='\0'; word_index++) {
			cout<<crypt[word_index];
		}
		cout<<endl;
	}

	return 0;
}
