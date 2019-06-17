#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
template <class T>
class  CList {
		T* vector;
		int size;
		int valid_size;

	public:
		CList() {}
		CList(int len) {
			int i;
			vector = new T[len];
			size = len;
			valid_size = 0;
			for(i=0; i<size; i++) {
				vector[i]=-1;
			}
		}

		void insert(T data,int loc = -1) {
			int i;
			if(loc==-1) {
				loc = valid_size;
			}

//			echo();

//			cout<<valid_size<<" "<<loc<<endl;

			for(i=valid_size; i>=loc; i--) {
				vector[i]=vector[i-1];
			}

			vector[loc] = data;
			valid_size++;

//			echo();
		}


		void clear(int loc = -1) {
			int i;
			if(loc==-1) {
				loc = valid_size-1;
			}

			for(i=loc; i<valid_size; i++) {
				vector[i]=vector[i+1];
			}
			valid_size--;

		}

		T& operator[](int index) {
			if(index<size)
				return vector[index];
		}

		void echo() {
			int i;
			for(i=0; i<valid_size-1; i++) {
				cout<<vector[i]<<" ";
			}
			cout<<vector[valid_size-1]<<endl;
		}

};

int main() {
	int i,n;
	int index,data1;
	double data2;
	CList<int> list1(100);
	cin>>n;

	for(i=0; i<n; i++) {
		cin>>data1;
		list1.insert(data1);
	}
	
	cin>>index>>data1;
	list1.insert(data1,index);

	cin>>index;
	list1.clear(index);

	list1.echo();

	CList<double> list2(100);
	cin>>n;
	for(i=0; i<n; i++) {
		cin>>data2;
		list2.insert(data2);
	}
	cin>>index>>data2;
	list2.insert(data2,index);

	cin>>index;
	list2.clear(index);

	list2.echo();

	return 0 ;
}

