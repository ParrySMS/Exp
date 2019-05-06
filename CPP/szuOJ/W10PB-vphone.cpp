#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class card {
	private:
		int num;
		char utype;

};
class Phone {
	private:
		int num;
		char utype;
		int state;
		string uname;

	public:
		Phone() {}
		Phone(int _num):num(_num) {
			cout<<_num<<" constructed."<<endl;
		}

		~Phone() {
			cout<<num<<" destructed."<<endl;
		}


		void init(int _num,char _utype,int _state,string _uname) {
			cout<<_num<<" constructed."<<endl;
			num = _num;
			utype = _utype;
			state = _state;
			uname = _uname;
		}

		bool show(int _num) {
			if(num == _num) {
//				Phone=80000003--Type=C--State=use--Owner=mary
				cout<<"Phone="<<num;
				cout<<"--Type="<<utype;

				string state_str = state?"use":"unuse";
				cout<<"--State="<<state_str;
				cout<<"--Owner="<<uname<<endl;
				return true;
			} else {
				return false;
			}
		}



};

void check (int num,Phone* phs,int size) {
	int i;
	for(i=0; i<size; i++) {
		if(phs[i].show(num)) {
			return;//true
		}
	}
	//false
	cout<<"wrong number."<<endl;
}

int main() {
	void check (int num,Phone* phs,int size) ;
	int t,i;
	int num;
	char utype;
	int state;
	string uname;
	int size =3;

	Phone* phs = new Phone[size];
	for(i=0; i<size; i++) {
		cin>>num>>utype>>state>>uname;
		phs[i].init(num,utype,state,uname);
	}

	cin>>t;
	while(t--) {
		cin>>num;
		check(num,phs,size);
	}
	
	delete [] phs;

	return 0 ;
}

