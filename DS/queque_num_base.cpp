#include <queue>
#include <stack>
#include <math.h>
#include <iostream>
#include <iomanip>
#include<stdio.h>
using namespace std;

stack <int> whole;//int num
queue <int>	decimal;

char getSingleChar(int num) {
	switch(num) {
		case 10:
			return 'A';
			break;
		case 11:
			return 'B';
			break;
		case 12:
			return 'C';
			break;
		case 13:
			return 'D';
			break;
		case 14:
			return 'E';
			break;
		case 15:
			return 'F';
			break;
		default:
			return '0' + num ;
	}
}
int main() {
	int i,t,k,num_w,num_d;
	char getSingleChar(int num) ;
	int n_int;
	double n;
	cin>>t;

	while(t--) {

		cin>>n>>k;

		if(k<=1||k>16) {
			break;
		}

		//int whole num
		n_int = (int)n;

		while(1) {
			num_w = n_int%k;
//			cout<<"push-int: "<<num_w<<endl;
			whole.push(num_w);
			n_int = n_int/k;

			if(n_int == 0) {
				break;
			}
		}

		//decimal num
		n = (double)(n-(int)n);
//		cout<<"decimal n--> "<<n;
		while(1) {
			n = n*k;
			num_d = int(n);
//			cout<<"push-dec: "<<num_d<<endl;
			decimal.push(num_d);

			if( n-0.0 < 0.0000000001) {
				break;
			}

			n = (double)(n-(int)n);
		}

		//get result

		while(!whole.empty()) {
			cout<<getSingleChar(whole.top());
			whole.pop();
		}

		cout<<".";

		//	need 3 dec
		while(decimal.size()<3) {
			decimal.push(0);
		}


		for(i=0; i<3; i++) {
			if(!decimal.empty()) {
				cout<<getSingleChar(decimal.front());
				decimal.pop();
			}
		}

		//clear
		while(!decimal.empty()) {
			decimal.pop();
		}

		cout<<endl;
	}
	return 0;
}
