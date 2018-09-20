#include<iostream>
#include<stdio.h>
using namespace std;

#define ok 0
#define error -1

class ListNode {
	public:
		int exp;
		int ratio;
		ListNode *next;
		ListNode() {
			next = NULL;
		}
};

class LinkList {
	public:
		ListNode *head;
		int len;
		LinkList();
		~LinkList();
		ListNode * last_index(int i);//i-1
		int get(int i);
		int insert(int i ,int ratio,int exp);
		int del(int i);
		void show(int res);

};

LinkList::LinkList() {
	head = new ListNode();
	len = 0;
}


LinkList::~LinkList() {
	ListNode *p,*q;
	p = head;
	while(p!=NULL) {
		q=p;
		p=p->next;
		delete q;
	}
	len = 0;
	head = NULL;
}


ListNode * LinkList::last_index(int i) {
	int index;
	ListNode *p;
	p = head;

	for(index=1; index<i; index++) {
		p=p->next;
		if(p==NULL) {
			break;
		}
	}
	return (p)?p:NULL;
}


void LinkList::show(int res) {
	if(res == error) {
		cout << "error";
	} else {
		bool has_count = false;
		ListNode *p;
		p = head->next;
		
		while(p!=NULL||p!=0) {
			if(p->ratio == 0) {
				if(p->next!=NULL && has_count ) {
					cout<<" + ";
				}
//				cout << "continue  ";
				p=p->next;
				continue;
			}

			if(p->ratio<0) {
				cout<<"("<< p->ratio << ")";
				has_count = true;
			} else { //>0
				cout<< p->ratio ;
				has_count = true;
			}


			if(p->exp<0) {
				cout<<"x^("<< p->exp << ")";
					has_count = true;
			} else if (p->exp>0) {
				cout<<"x^"<< p->exp;
					has_count = true;
			}

			if(p->next!= NULL && p->next->ratio != 0) {
				cout<<" + ";
			}

			p=p->next;
		}
	}
	cout<<endl;
}

int LinkList::insert(int i ,int ratio,int exp) {
	ListNode *p,*q;
	if(i<=0||i>len+1) {
		return error;
	}

	q = new ListNode();

	p = last_index(i);//i-1

	q->next = p->next;
	q->ratio = ratio;
	q->exp = exp;
	p->next = q;
	len++;

	return ok;
}

int LinkList::del(int i) {
	ListNode *p,*q;

	if(i<=0||i>len) {
		return error;
	}

	p = last_index(i);//i-1
	q = last_index(i+1);

	if(q == NULL) { //end
		p->next = NULL;
	} else { //mid
		p->next = q->next;
		delete q;
	}

	return ok;

}

int LinkList::get(int i) {
	ListNode *p;

	if(i<=0||i>len) {
		return error;
	}

	p = last_index(i+1);

	if(p==NULL) {
		return error;
	}

	return ok;

}

int merge(LinkList* la,LinkList* lb) {

	int i;
	int min_len = (la->len>lb->len)?lb->len:la->len;
	bool pre_insert = false;

	if(la->len + lb->len == 0) {
		return error;
	}

	//la is result
	if(lb->len == 0) {
		return ok;
	}

	//link lb to null la
	if(la->len == 0 && lb->len !=0) {
		la = lb;
		return ok;
	}

	//la lb merge
	ListNode *pa,*pb;
	pa = la->last_index(2);//self
	pb = lb->last_index(2);

//	cout<<" get pa pb\n";
	for(i=1; i<=min_len+1; i++) {
		pre_insert = false;

		if(pa == NULL) {
//			cout<<" link lb \n";
			pa=la->last_index(i);
			pa->next = pb;
			return ok;
		} else if(pb == NULL) { //la finish
//			cout<<" lb null ,la finish \n";
			return ok;
		}

		if(pa->exp > pb->exp) {
//			cout<<" insert <- \n";
			la->insert(i,pb->ratio,pb->exp);
			pre_insert = true;

		} else if(pa->exp<pb->exp) {
//			cout<<" insert -> \n";
			la->insert(i+1,pb->ratio,pb->exp);
		} else if(pa->exp == pb->exp) {
//			cout<<" counting \n";
			pa->ratio +=pb->ratio;
		}



		//next

		if(!pre_insert && pa!=NULL) {//pre insert mean pa has become next one
			pa = pa->next;
		}

		if(pb!=NULL) {
//			cout<<" del lb \n";
			pb = pb->next;
//			lb->del(i);
		}

//		cout<<" pa:"<<pa<<'\n';
//		cout<<" pb:"<<pb<<'\n';
	}
	return ok;

}


//main

int merge(LinkList* la,LinkList* lb);
int main() {

	int num,i,j,n,t,index,ratio,exp,res;

	LinkList* ll[10];
	//init
	for(i=0; i<10; i++) {
		ll[i]= new LinkList();
	}

	cin >> t;

	for(i=0; i<2*t; i++) {// t group
		cin>> n;
		for(j=0; j<n; j++) { //n item group 1
			cin>>ratio>>exp;
			ll[i]->insert(j+1,ratio,exp);
		}

		ll[i]->show(ok);

		if((i+1)%2 == 0 && i!=0) { //even
//			cout<<" even\n";
			res = merge(ll[i-1],ll[i]);
			ll[i-1]->show(res);
		}
	}



	for(i=0; i<10; i++) {
		ll[i]->~LinkList();
	}

	return 0;
}

