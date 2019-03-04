#include <iostream>
using namespace std;
inline bool mod6(int num) {
	return (num%6 == 0);
}

inline bool size6(int num){
	 return (num>99999 && num<=999999);
}

inline bool last6(int num){
   return (num%10 == 6);
}


int main() {
	int i,t,n;

	cin>>t;
	while(t--) {
		cin>>n;
		if(mod6(n) || size6(n) || last6(n)){
			cout<<"Yes"<<endl;
		}else{
			cout<<"No"<<endl;
		}

	}
	return 0;
}
