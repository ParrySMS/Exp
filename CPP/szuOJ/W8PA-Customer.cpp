#include <iostream>
#include <math.h>
#include <iomanip>
using namespace std;
class Customer {
	private:
		static int totalNum;
		static int rent;
		static int year;
		int cid;
		string cname;

	public:
		Customer(string name)
			:cname(name) {
			totalNum++;
			cid = totalNum;
		}
		Customer() {
			totalNum++;
			cid = totalNum;
		}
		~Customer() {
			totalNum=0;
			rent =150;
			year=2015;
		}
		static void setYear(int y) {
			year = y;
		}
		static void setRent(int r) {
			rent = r;
		}
		static void setNum(int n) {
			totalNum = n;
		}

		void setName(string name) {
			cname.clear();
			cname = name;
		}

		void display() {
			cout<<cname<<" ";
			cout<<year;

			cout.fill('0');//ÉèÖÃÌî³ä×Ö·û
			cout.width(4);//ÉèÖÃÎ»¿í
			cout<<cid<<" ";

			int total_rent = cid*rent;
			cout<<cid<<" "<<total_rent<<endl;

			//Cindy 20150004 4 600
		}


};

int Customer::year = 2015;
int Customer::rent = 150;
int Customer::totalNum = 0;
int main() {
	int t,num,j=0,year;
	cin>>t;

	while(t--) {
		cin>>year;
		Customer::setYear(year);
		Customer::setNum(j);
		string input;
		string* name_ar = new string[15];

		for(num=0; ; num++) {
			input.clear();
			cin>>input;

			if(input!="0") {
				name_ar[num] = input;
			} else {
				break;
			}
		}

		Customer *cu = new Customer[15];

		for(j=0; j<num; j++) {
			cu[j].setName(name_ar[j]);
			cu[j].display();
		}

		delete []name_ar;
		delete []cu;

	}

	return 0 ;
}

