#include <iostream>
#include <iomanip>
using namespace std;

//avg
void arI(int *ar,int n) {
	int i,sum = 0;
	for(i=0; i<n; i++) {
		sum += ar[i];
	}

	cout<<sum/n<<endl;
}

//max char
void arC(char *ar,int n) {
	int i;
	char max='\0';
	for(i=0; i<n; i++) {
		if(ar[i]>max) {
			max = ar[i];
		}
	}
	cout<<max<<endl;
}

//min
void arF(double *ar,int n) {
	int i;
	double min= 99999.0;
	for(i=0; i<n; i++) {
		if(ar[i]<min) {
			min = ar[i];
		}
	}

	cout<<setiosflags(ios::fixed) <<setprecision(1)<<min<<endl;
}

int main() {
	int  i,t,n,mid,index;
	char type;
	cin>>t;
	while(t--) {
		cin>>type>>n;
		int *ar1 = new int[n]();
		char *ar2 = new char[n]();
		double *ar3 = new double[n]();


		switch(type) {
			case 'I':
				for(i=0; i<n; i++) {
					cin>>ar1[i];
				}
				arI(ar1,n);
				break;
			case 'C':
				for(i=0; i<n; i++) {
					cin>>ar2[i];
				}
				arC(ar2,n);
				break;
			case 'F':
				for(i=0; i<n; i++) {
					cin>>ar3[i];
				}
				arF(ar3,n);
				break;
		}

		delete [] ar1;
		delete [] ar2;
		delete [] ar3;

	}

	return 0;
}
