#include <iostream>
#include <iomanip>
using namespace std;
string *mon = new string[12];

int main() {
	int t,num;
	mon[0] ="January";
	mon[1] ="February";
	mon[2] ="March";
	mon[3] ="April";
	mon[4] ="May";
	mon[5] ="June";
	mon[6] ="July";
	mon[7] ="August";
	mon[8] ="September";
	mon[9] ="October";
	mon[10] ="November";
	mon[11] ="December";
	cin>>t;
	while(t--) {
		cin>>num;
		if(num<1||num>12) {
			cout<<"error"<<endl;
		} else {
			cout<<mon[num-1]<<endl;
		}
	}
	return 0;
}
