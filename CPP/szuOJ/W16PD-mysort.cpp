#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;


class Point {
	public:
		double x,y;
		Point() {};
		Point(double x,double y):x(x),y(y) {};
		void init(double x,double y) {
			this->x = x;
			this->y = y;
		}

		void init(const Point& p) {
			this->x = p.x;
			this->y = p.y;
		}

		double rsize() {
			return sqrt( x*x + y*y );
		}

};

template <class T>
class BoundArray {
		T* vector;
		int size;

	public:
		BoundArray() {}
		BoundArray(int len) {
			vector = new T[len];
			size = len;
		}
//		~BoundArray() {
//			delete vector;
//			size = 0;
//		}

		T& operator[](int index) {
			if(index<size)
				return vector[index];
		}


		void echo() {
			int i;
			for(i=0; i<size; i++) {
				cout<<vector[i]<<" ";
			}
			cout<<endl;
		}

		void objEcho() {
			int i;
			for(i=0; i<size-1; i++) {
				cout<<setiosflags(ios::fixed) <<setprecision(1);
				cout<<"("<<vector[i].x<<", "<<vector[i].y<<") ";
			}
			cout<<"("<<vector[size-1].x<<", "<<vector[size-1].y<<")"<<endl;
		}

		void objSort() {
			int i,j,min;
			T tp;

			for(i=0; i<size-1; i++) {
				min = i;
				for(j=i+1; j<size; j++) {
					if(	vector[j].rsize()<=vector[min].rsize()) {
						min = j;
					}
				}

				if(min!=i) {
					tp.init(vector[i]);
					vector[i].init(vector[min]);
					vector[min].init(tp);
				}
			}

			objEcho();
		}

		void sort() {
			int i,j,min;
			T t;
			for(i=0; i<size-1; i++) {
				min = i;
				for(j=i+1; j<size; j++) {
					if(vector[j]<=vector[min]) {
						min = j;
					}
				}

				if(min!=i) {
					t=vector[i];
					vector[i]=vector[min];
					vector[min]=t;
				}
			}

			echo();
		}

		void init(int len) {
			vector = new T[len];
			T data;
			size = len;
			int i;
			for(i=0; i<len; i++) {
				cin>>data;
				vector[i] = data;
			}
		}

		void objInit(int len) {
			T data;
			size = len;
			int i;
			double x,y;
			vector = new T[len];
			for(i=0; i<len; i++) {
				cin>>x>>y;
				vector[i].init(x,y);
			}

		}


};

int main() {
	int t,n;
	char type;

	cin>>t;
	while(t--) {
		cin>>type>>n;
		BoundArray<int> ar1;
		BoundArray<string> ar2;
		BoundArray<double> ar3;
		BoundArray<Point> ar4;
		switch(type) {
			case 'I':
				ar1.init(n);
				ar1.sort();
				break;
			case 'S':
				ar2.init(n);
				ar2.sort();
				break;
			case 'D':
				ar3.init(n);
				ar3.sort();
				break;
			case 'P':
				ar4.objInit(n);
				ar4.objSort();
				break;
		}
	}

	return 0 ;
}

