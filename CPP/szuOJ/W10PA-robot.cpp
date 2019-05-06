#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
static int tran_num = 0;

class Robot {
	private:
		string name;
		char type;
		int grade;
		int hp;//health
		int dp;//defense
		int kp;//kill

	public:
		Robot() {}
		void echo() {
			//X001--H--5--250--25--25
			cout<<name<<"--";
			cout<<type<<"--";
			cout<<grade<<"--";
			cout<<hp<<"--";
			cout<<kp<<"--";
			cout<<dp<<endl;
		}
		
		void init(string _name,char _type,int _grade,char tran) {
			name = _name;
			type = _type;
			grade = _grade;
			switch(tran) {
				case 'N':
					hp=5*grade;
					dp = hp;
					kp = hp;
					break;
				case 'A':
					hp=5*grade;
					dp = hp;
					kp = 10*grade;
					break;
				case 'D':
					hp=5*grade;
					dp = 10*grade;
					kp = hp;
					break;
				case 'H':
					hp=50*grade;
					dp = 5*grade;
					kp = dp;
					break;
			}

			if(	type != tran) {
				type = tran;
				tran_num++;
			}
		}
};
int main() {
	int t,i;
	string name;
	char type,tran;
	int grade;
	cin>>t;
	Robot* rs = new Robot[t];
	for(i=0; i<t; i++) {
		cin>>name>>type>>grade>>tran;
		rs[i].init(name,type,grade,tran);
		rs[i].echo();
	}
	
	cout<<"The number of robot transform is "<<tran_num<<endl;
	
	delete []rs;

	return 0 ;
}

