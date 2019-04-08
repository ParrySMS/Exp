#include <iostream>
#include <cstring>
#include <algorithm>
#include <math.h>
#include <iomanip>
using namespace std;

class ACC {
	public:
		int card_no;
		int phone;
		int pw;
		int balance;
		ACC() {};
		ACC(int card_no,int phone,int pw,int balance)
			:card_no(card_no),phone(phone),pw(pw),balance(balance) {
		};

		void init(int card_no,int phone,int pw,int balance) {
			this->card_no = card_no;
			this->phone = phone;
			this->pw = pw;
			this->balance = balance;
		}
};


// -1 not found
int getIDByPhone(int phone,ACC * acc,int n) {
	for(int i=0; i<n; i++) {
		if(acc[i].phone == phone ) {
			return i;
		}
	}

	return -1;

}

int main() {
	int i,n,k;
	int card_no;
	int phone;
	int pw;
	int balance;

	cin>>n;
	ACC * acc = new ACC[n];
	for(i=0; i<n; i++) {
		cin>>card_no>>phone>>pw>>balance;
		acc[i].init(card_no, phone, pw, balance);
	}

	cin>>k;
	int money;

	while(k--) {
		cin>>phone>>pw>>money;
		int id = getIDByPhone(phone,acc,n);
		if(id==-1) {
			cout<<"ÊÖ»úºÅ²»´æÔÚ"<<endl;
			continue;
		} else if(pw!=acc[id].pw) {
			cout<<"ÃÜÂë´íÎó"<<endl;
			continue;
		} else if(money>acc[id].balance) {
			cout<<"¿¨ºÅ"<<acc[id].card_no<<"--Óà¶î²»×ã"<<endl;
			continue;
		} else {
			acc[id].balance -=money;
			cout<<"¿¨ºÅ"<<acc[id].card_no<<"--Óà¶î"<<acc[id].balance<<endl;
			continue;
		}
	}

	return 0;
}
