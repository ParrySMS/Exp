#include <string>
#include <iostream>
#include <algorithm>
using namespace std;

typedef struct birth {
	int year;
	int month;
	int day;
} bir;

bool cmp(bir x,bir y){
	if(x.year!=y.year) return x.year<y.year;
	if(x.month!=y.month) return x.month<y.month;
	if(x.day!=y.day) return x.day<y.day;
	
}


int main() {
	int t,i,y,m,d;
	cin>>t;
	bir* bir_ar = new bir[t];

	for(i=0; i<t; i++) {
		cin>>bir_ar[i].year>>bir_ar[i].month>>bir_ar[i].day;
	}
	
	sort(bir_ar,bir_ar+t,cmp);
	
	cout<<bir_ar[1].year<<"-";
	cout<<bir_ar[1].month<<"-";
	cout<<bir_ar[1].day<<endl;
	
	delete [] bir_ar;
	return 0;
}
