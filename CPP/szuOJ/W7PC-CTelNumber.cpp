#include <iostream>
#include <stdio.h>
using namespace std;

class CTelNumber {
		string phone;

	public:
		CTelNumber() {}
		CTelNumber(string str):phone(str) {	}
		void init(string str) {
			phone = str;
		}

		void upgrade() {
			int len = phone.length();

			for(int i=0; i<len; i++) {
				if(!isdigit(phone[i])) {
					cout<<"Illegal phone number"<<endl;
					return;
				}
			}


			if(len!=7) {
				cout<<"Illegal phone number"<<endl;
				return;
			} else {
				char first = phone[0];
				switch(first) {
					case '2':
					case '3':
					case '4':
						phone.insert(0,"8");
						break;
					case '5':
					case '6':
					case '7':
					case '8':
						phone.insert(0,"2");
						break;
					default:
						cout<<"Illegal phone number"<<endl;
						return;
				}

				cout<<phone<<endl;
			}
			return;
		}
};

int main() {
	int t;
	string str;
	cin>>t;
	CTelNumber* ctn = new CTelNumber();
	while(t--) {
		cin>>str;
		ctn->init(str);
		ctn->upgrade();
	}
	delete ctn;
	return 0 ;
}


