#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class CStr {
		char *p;
	public:
		CStr() {	};
		CStr(char *s) {
			p = s;
		};
		char* getStr() {
			return p;
		}
		friend bool operator>(CStr&,CStr&);
		friend bool operator<(CStr&,CStr&);
		friend bool operator==(CStr&,CStr&);

		void show() {
			cout<<p<<endl;
		}
};

bool operator>(CStr& a,CStr& b) {
	int res;
	res = strcmp(a.getStr(),b.getStr());
	if(res>0) {
		return true;
	}
	return false;

}

bool operator<(CStr&a,CStr&b) {
	int res;
	res = strcmp(a.getStr(),b.getStr());
	if(res<0) {
		return true;
	}
	return false;

}

bool operator==(CStr&a,CStr&b) {
	int res = strcmp(a.getStr(),b.getStr());
	if(res=0) {
		return true;
	}
	return false;

}

char* getPointer(string str) {
	int len = str.size();
	char* pbuf = new char[len+1];
	str.copy(pbuf,len);
	pbuf[len] = '\0';
	return pbuf;
}

int main() {
	int len;
	char *pa,*pb,*pc;
	string strA,strB,strC;
	getline(cin,strA);
	getline(cin,strB);
	getline(cin,strC);

	pa = getPointer(strA);
	pb = getPointer(strB);
	pc = getPointer(strC);

	CStr A(pa);
	CStr B(pb);
	CStr C(pc);

	if(A>B) {
		A.show();
	} else {
		B.show();
	}

	if(A<C) {
		A.show();
	} else {
		C.show();
	}

	if(B==C) {
		B.show();
	} else {
		C.show();
	}

	return 0 ;
}

