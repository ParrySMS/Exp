#include <queue>
#include <stack>
#include <math.h>
#include <iostream>
#include <iomanip>
#include<stdio.h>
using namespace std;

stack <int> whole;//int num
queue <int>	decimal;

int main() {
	int i,t,k,num_w,num_d;

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
				cout<<"push-int: "<<num_w<<endl;
			whole.push(num_w);
			n_int = n_int/k;

			if(n_int ==0) {
				break;
			}
		}

		//decimal num
		n = (double)(n-(int)n);
		cout<<"decimal n--> "<<n;

		while(1) {
			n = n*k;
			num_d = (n>=1)?1:0;
				cout<<"push-dec: "<<num_d<<endl;
			decimal.push(num_d);
			n = (n>=1)?n-1:n;

			if(n == 0.0) {
				break;
			}
		}

		//get result
		n = 0.0;
		while(!whole.empty()) {
			n = n*10 + whole.top();
			//cout<<"int "<<whole.top()<<endl;
			whole.pop();
		}

		i = -1;
		while(!decimal.empty()) {
			n = n + (pow(10,i)*decimal.front());
			i--;
			//cout<<"dec "<<decimal.front()<<endl;
			decimal.pop();
		}

		cout<<fixed<<setprecision(3)<<n<<endl;

	}




	return 0;
}
