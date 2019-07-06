#include<iostream>
using namespace std;

class Date {
	private:
		int y, m ,d;
	public:
		Date(int y,int m,int d):y(y),m(m),d(d) {}
		friend ostream& operator<<(ostream &stream,Date &date);
		friend istream& operator>>(istream &stream,Date &date);
};

ostream& operator<<(ostream &stream,Date &date) {
	stream<<date.y<<"/"<<date.m<<"/"<<date.d<<endl;
	return stream;
}

istream& operator>>(istream &stream,Date &date) {
	stream>>date.y>>date.m>>date.d;
	return stream;
}

int main( ) {
	Date Cdate(2004,1,1);
	cout<<"Current date:"<<Cdate<<endl;
	cout<<"Enter new date:";
	cin>>Cdate;
	cout<<"New date:"<<Cdate<<endl;
}

