#include <iostream>
#include <iomanip>
using namespace std;
//全局
double * cur = new double[4];

int main() {
	int i,t;
	double num,res,radio;
	char type;
	cur[0] = 6.2619; //美  D
	cur[1] = 6.6744; //欧  E
	cur[2] = 0.0516; //日 Y
	cur[3] = 0.8065; //港 H
	cin>>t;
	while(t--) {
		cin>>type>>num;
		switch(type) {
			case 'D':
				radio = cur[0];
				break;
			case 'E':
				radio = cur[1];
				break;
			case 'Y':
				radio = cur[2];
				break;
			case 'H':
				radio = cur[3];
				break;
		}
		res = radio*num;
		cout<<fixed<<setprecision(4)<<res<<endl;
	}

	return 0;
}
